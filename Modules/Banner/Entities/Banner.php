<?php

namespace Modules\Banner\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Banner\Traits\HasPositionsTrait;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;
use Modules\Share\Traits\HasImageTrait;

class Banner extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus, HasPositionsTrait;

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

    // ********************************************* Relations

    // ********************************************* methods

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedTitle(int $size = 50): string
    {
        return Str::limit($this->title, 50);
    }

    // ********************************************* paths

    /**
     * @return string
     */
    public function imagePath(): string
    {
        return asset($this->image);
    }

    // ********************************************* FA Properties

    /**
     * @return mixed|string
     */
    public function getFaPosition(): mixed
    {
        return self::$positions[$this->position] ?? 'مکان بنر مشخص نیست.';
    }
}
