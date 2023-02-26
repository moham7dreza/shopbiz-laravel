<?php

namespace Modules\Share\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\User\Entities\User;

class File extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['file_path', 'file_size', 'file_type', 'status', 'fileable_id', 'fileable_type', 'user_id'];

    // ********************************************* Relations

    /**
     * @return MorphTo
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // ********************************************* Methods

    // ********************************************* paths

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return asset($this->file_path);
    }

    // ********************************************* FA Properties

    /**
     * @param string $unit
     * @return string|array
     */
    public function getFaFileSize(string $unit = "KB"): string|array
    {
        return convert($this->file_size, $unit);
    }
}
