<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'image',
        'url',
        'position',
        'status'
    ];

    /**
     * @var array|string[]
     */
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

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return asset($this->image);
    }

    /**
     * @return string
     */
    public function limitedTitle(): string
    {
        return Str::limit($this->title, 50);
    }

    /**
     * @return string
     */
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return mixed|string
     */
    public function textPosition(): mixed
    {
        return self::$positions[$this->position] ?? 'مکان بنر مشخص نیست.';
    }
}
