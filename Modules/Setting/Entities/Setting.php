<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;

class Setting extends Model
{
    use HasFactory, HasFaDate;

    /**
     * @var string[]
     */
    protected $casts = ['logo' => 'array', 'icon' => 'array'];


    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description', 'keywords', 'logo', 'icon',
        'author', 'address', 'mobile', 'email', 'postal_code', 'social_media', 'bank_account'];


    // ********************************************* Relations

    // ********************************************* Methods

    /**
     * @return mixed
     */
    public function getMobile(): mixed
    {
        return json_decode($this->mobile)->mobile ?? 'موبایل پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getOfficePhone(): mixed
    {
        return json_decode($this->mobile)->office_telephone ?? 'شماره تماس پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getEmail(): mixed
    {
        return json_decode($this->email)->office_mail ?? 'ایمیل پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getInstagram(): mixed
    {
        return json_decode($this->social_media)->instagram ?? 'اینستا پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getTelegram(): mixed
    {
        return json_decode($this->social_media)->telegram ?? 'تلگرام پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getWhatsApp(): mixed
    {
        return json_decode($this->social_media)->whatsapp ?? 'واتس اپ پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getYoutube(): mixed
    {
        return json_decode($this->social_media)->youtube ?? 'یوتیوب پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getBankAccount(): mixed
    {
        return json_decode($this->bank_account)->primary ?? 'اطلاعات بانکی پیدا نشد';
    }

    /**
     * @return mixed
     */
    public function getCentralOfficeAddress(): mixed
    {
        return json_decode($this->address)->addresses->central_office ?? 'آدرسی پیدا نشد';
    }

    // ********************************************* paths

    /**
     * @return string
     */
    public function logo(): string
    {
        return asset($this->logo);
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return asset($this->icon);
    }

    // ********************************************* FA Properties

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedDescription(int $size = 50): string
    {
        return Str::limit($this->description, $size) ?? '-';
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedKeywords(int $size = 50): string
    {
        return Str::limit($this->keywords, $size);
    }
}
