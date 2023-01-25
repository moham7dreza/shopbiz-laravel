<?php

namespace Modules\Auth\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Modules\Auth\Entities\Otp;
use Modules\Share\Services\Message\Email\EmailService;
use Modules\Share\Services\Message\MessageService;
use Modules\Share\Services\Message\SMS\SmsService;
use Modules\User\Entities\User;

class AuthService
{
    /**
     * @param $otp
     * @return mixed
     */
    public function resendOtp($otp): mixed
    {
        $user = $otp->user()->first();
        [$otpCode, $token] = $this->store($user->id, $otp->type, $otp->login_id);
        $this->sendSmsOrEmailToUser($user, $otp->type, $otp->login_id, $otpCode);
        return $token;
    }


    /**
     * @param $id
     * @param $userRepo
     * @return mixed|string
     */
    public function loginRegister($id, $userRepo): mixed
    {
        $result = $this->findOrCreateUserByMobileOrEmail($id, $userRepo);
        if ($result === 'id invalid') {
            return $result;
        }
        $user = $result['user'];
        $type = $result['type'];
        [$otpCode, $token] = $this->store($user->id, $type, $id);
        $this->sendSmsOrEmailToUser($user, $type, $id, $otpCode);
        return $token;
    }

    /**
     * @param $userId
     * @param $type
     * @param $id
     * @return array
     */
    private function store($userId, $type, $id): array
    {
        //create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);

        $this->query()->create([
            'token' => $token,
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'login_id' => $id,
            'type' => $type,
        ]);

        return [$otpCode, $token];
    }


    /**
     * @param $id
     * @param $userRepo
     * @return array|string
     */
    private function findOrCreateUserByMobileOrEmail($id, $userRepo): array|string
    {
        //check id is email or not
        if (filter_var($id, FILTER_VALIDATE_EMAIL)) {
            $type = 1; // 1 => email
            $user = $userRepo->findByEmail($id);
            if (empty($user)) {
                $newUser['email'] = $id;
            }
        } //check id is mobile or not
        elseif (preg_match('/^(\+98|98|0)9\d{9}$/', $id)) {
            $type = 0; // 0 => mobile;
            // all mobile numbers are in on format 9** *** ***
            $id = ltrim($id, '0');
            $id = substr($id, 0, 2) === '98' ? substr($id, 2) : $id;
            $id = str_replace('+98', '', $id);

            $user = $userRepo->findByMobile($id);
            if (empty($user)) {
                $newUser['mobile'] = $id;
            }
        } else {
            return 'id invalid';
//            $errorText = 'شناسه ورودی شما نه شماره موبایل است نه ایمیل';
//            return to_route('auth.login-register-form')->withErrors(['id' => $errorText]);
        }

        if (empty($user)) {
            $newUser['password'] = '98355154';
            $newUser['activation'] = User::ACTIVATE;
            $user = User::query()->create($newUser);
        }
        return ['user' => $user, 'type' => $type];
    }


    /**
     * @param $user
     * @param $type
     * @param $id
     * @param $otpCode
     * @return void
     */
    private function sendSmsOrEmailToUser($user, $type, $id, $otpCode): void
    {
        //send sms or email

        if ($type == Otp::TYPE_MOBILE) {
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('smsConfig.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText("مجموعه آمازون \n  کد تایید : $otpCode");
            $smsService->setIsFlash(true);

            $messagesService = new MessageService($smsService);

        } elseif ($type == Otp::TYPE_EMAIL) {
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی',
                'body' => "کد فعال سازی شما : $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($id);

            $messagesService = new MessageService($emailService);

        }
        $messagesService->send();
    }

    /**
     * @param $otp
     * @return void
     */
    public function updateAndLoginUser($otp): void
    {
        // if everything is ok :
        $otp->update(['used' => Otp::CODE_USED]);
        $user = $otp->user()->first();
        if ($otp->type == Otp::TYPE_MOBILE && empty($user->mobile_verified_at)) {
            $user->update(['mobile_verified_at' => Carbon::now()]);
        } elseif ($otp->type == Otp::TYPE_EMAIL && empty($user->email_verified_at)) {
            $user->update(['email_verified_at' => Carbon::now()]);
        }
        Auth::login($user);
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return Otp::query();
    }
}
