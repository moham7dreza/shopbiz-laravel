<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;

class Setting extends Model
{
    use HasFactory, HasFaDate;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    /**
     * @var string[]
     */
    protected $casts = ['logo' => 'array', 'icon' => 'array'];


    /**
     * @var string[]
     */
    protected $fillable = ['title', 'description', 'keywords', 'logo', 'icon'];

    //Methods

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

    /**
     * @return string
     */
    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50);
    }

    /**
     * @return string
     */
    public function limitedKeywords(): string
    {
        return Str::limit($this->keywords, 50);
    }

}
