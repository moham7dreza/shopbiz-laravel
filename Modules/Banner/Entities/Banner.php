<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasFaDate;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];
    protected $casts = ['image' => 'array'];

    protected $fillable = [
        'title',
        'image',
        'url',
        'position',
        'status'
    ];

    public static array $positions = [
        0 => 'اسلاید شو (صفحه اصلی)',
        1 => 'کنار اسلاید شو (صفحه اصلی)',
        2 => 'دو بنر تبلیغی بین دو اسلایدر  (صفحه اصلی)',
        3 => 'دو بنر تبلیغی بین دو اسلایدر پایینی  (صفحه اصلی)',
        4 => 'بنر تبلیغی بزرگ پایین دو اسلایدر  (صفحه اصلی)',
        5 => 'بنر تبلیغی برندها در اتمام صفحه  (صفحه اصلی)',
        6 => 'چهار بنر تبلیغی در میان صفحه  (صفحه اصلی)',
    ];

    // Methods
    public function imagePath(): string
    {
        return asset($this->image);
    }

    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    public function textPosition()
    {
        return self::$positions[$this->position] ?? self::$postBannersPositions[$this->position] ?? 'مکان بنر مشخص نیست.';
    }
}
