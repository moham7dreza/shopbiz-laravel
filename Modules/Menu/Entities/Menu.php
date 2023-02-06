<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasFaPropertiesTrait;

class Menu extends Model
{
    use HasFactory, SoftDeletes, HasFaDate, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $casts = ['image' => 'array'];

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'url', 'parent_id', 'status'];


    // ********************************* scope

    /**
     * @param $query
     * @return mixed
     */
    public function scopeParent($query): mixed
    {
        return $query->where('parent_id', null);
    }

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getParentName(): string
    {
        return is_null($this->parent_id) ? 'منوی اصلی' : $this->parent->name;
    }

    // ********************************************* paths


    // ********************************************* FA Properties
}
