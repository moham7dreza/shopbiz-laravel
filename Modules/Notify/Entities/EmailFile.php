<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;


class EmailFile extends Model
{
    /**
     * @var string
     */
    protected $table = 'public_mail_files';

    use HasFactory, SoftDeletes, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['public_mail_id', 'file_path', 'file_size', 'file_type', 'status'];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class, 'public_mail_id');
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
