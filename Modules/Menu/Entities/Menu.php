<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaDate;

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


    // Relations

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

    // Methods

    /**
     * @return string
     */
    public function textParentName(): string
    {
        return is_null($this->parent_id) ? 'منوی اصلی' : $this->parent->name;
    }
}
