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

    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    protected $casts = ['logo' => 'array', 'icon' => 'array'];


    protected $fillable = ['title', 'description', 'keywords', 'logo', 'icon'];

    //Methods
    public function logo(): string
    {
        return asset($this->logo);
    }

    public function icon(): string
    {
        return asset($this->icon);
    }

    public function limitedDescription(): string
    {
        return Str::limit($this->description, 50);
    }

    public function limitedKeywords(): string
    {
        return Str::limit($this->keywords, 50);
    }

}
