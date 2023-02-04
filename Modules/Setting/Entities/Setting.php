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
    protected $fillable = ['title', 'description', 'keywords', 'logo', 'icon'];


    // ********************************************* Relations

    // ********************************************* Methods

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
