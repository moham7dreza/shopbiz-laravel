<?php

namespace Modules\Share\Traits;

use Illuminate\Http\RedirectResponse;
use Modules\Share\Services\ShareService;

trait ShowMessageWithRedirectTrait
{
    public const TIMER = 5000;

    /**
     * Show success message with redirect;
     *
     * @param string $title
     * @param string $status
     * @param array $params
     * @return RedirectResponse
     */
    private function successMessageWithRedirect(string $title, string $status = 'success', array $params = []): RedirectResponse
    {
        if (empty($this->redirectRoute)) {
            return redirect()->back()->with('swal-error', 'مسیر برگشت یافت نشد.');
        }
        return to_route($this->redirectRoute, $params)->with($status, $title);
    }

    /**
     * Show success message with redirect;
     *
     * @param string $msg
     * @param string $title
     * @param string $type
     * @param string $status
     * @param array $params
     * @return RedirectResponse
     */
    private function showMessageWithRedirectRoute(string $msg, string $title = 'موفقیت آمیز', string $type = 'alert animated', string $status = 'success', array $params = []): RedirectResponse
    {
        if (empty($this->redirectRoute)) {
            return $this->showAlertWithRedirect(message: 'مسیر برگشت یافت نشد.', title: 'خطا', type: 'error');
        }
        if ($type === 'alert') {
            return $this->showAlertWithRedirect(message: $msg, title: $title, alertType: 'normal', type: $status, route: $this->redirectRoute, params: $params);
        } elseif ($type === 'alert animated') {
            return $this->showAlertWithRedirect(message: $msg, title: $title, type: $status, route: $this->redirectRoute, params: $params);
        } elseif ($type === 'alert animated with footer') {
            return $this->showAlertWithRedirect(message: $msg, title: $title, alertType: 'animated with footer', type: $status, route: $this->redirectRoute, params: $params);
        } elseif ($type === 'toast') {
            return $this->showToastWithRedirect(title: $msg, toastType: 'normal', type: $status, route: $this->redirectRoute, params: $params);
        } elseif ($type === 'toast animated') {
            return $this->showToastWithRedirect(title: $msg, type: $status, route: $this->redirectRoute, params: $params);
        } else {
            return $this->showAlertWithRedirect(message: 'نوع پیام را به درستی مشخص کنید.', title: 'خطا', type: 'error');
        }
    }

    /**
     * @param $title
     * @param string $toastType
     * @param string $type
     * @param int $timer
     * @param null $route
     * @param array $params
     * @return RedirectResponse
     */
    protected function showToastWithRedirect($title, string $toastType = 'animated', string $type = 'success', int $timer = self::TIMER, $route = null, array $params = []): RedirectResponse
    {
        if ($toastType === 'normal') {
            ShareService::showToast($title, $type, $timer);
        } elseif ($toastType === 'animated') {
            ShareService::showAnimatedToast($title, $type, $timer);
        }
        return is_null($route) ? back()->with(['block' => 'yes']) : to_route($route, $params)->with(['block' => 'yes']);
    }

    /**
     * @param $message
     * @param string $title
     * @param string $alertType
     * @param string $type
     * @param int $timer
     * @param null $route
     * @param array $params
     * @return RedirectResponse
     */
    protected function showAlertWithRedirect($message, string $title = 'موفقیت آمیز', string $alertType = 'animated', string $type = 'success', int $timer = self::TIMER, $route = null, array $params = []): RedirectResponse
    {
        if ($alertType === 'normal') {
            ShareService::showAlert($message, $title, $type, $timer);
        } elseif ($alertType === 'animated') {
            ShareService::showAnimatedAlert($message, $title, $type, $timer);
        } elseif ($alertType === 'animated with footer') {
            ShareService::showAnimatedAlertWithFooter($message, $title, $type, $timer);
        }
        return is_null($route) ? back()->with(['block' => 'yes']) : to_route($route, $params)->with(['block' => 'yes']);
    }

    /**
     * @param array $params
     * @return RedirectResponse
     */
    private function onlyRedirect(array $params = array()): RedirectResponse
    {
        return to_route($this->redirectRoute, $params);
    }

    /******************************************************************************************************************/
    /**
     * @param $recordsCount
     * @return void
     */
    public function showToastOfFetchedRecordsCount($recordsCount): void
    {
        ShareService::showAnimatedToast('به تعداد ' . convertEnglishToPersian($recordsCount) . ' رکورد از نتایج جست و جو یافت شد.', 'info', 7000)->position('top-left');
    }

    /**
     * @return RedirectResponse
     */
    public function showAlertOfNotResultFound(): RedirectResponse
    {
        return $this->showMessageWithRedirectRoute(msg: 'هیچ نتیجه ای متناسب با کلمه مربوطه یافت نشد.', title: 'هشدار', status: 'warning');
    }

    /**
     * @param $dir
     * @return void
     */
    public function showToastOfSelectedDirection($dir): void
    {
        ShareService::showAnimatedToast('داده ها به صورت ' . ($dir == 'asc' ? 'صعودی' : 'نزولی') . ' مرتب شدند.', type: 'info')->position('top-left');
    }
}
