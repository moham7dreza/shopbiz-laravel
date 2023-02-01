<?php

namespace Modules\Notify\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\Share\Traits\HasFaPropertiesTrait;

class EmailFile extends Model
{
    /**
     * @var string
     */
    protected $table = 'public_mail_files';

    use HasFactory, SoftDeletes, HasDefaultStatus, HasFaPropertiesTrait;

    /**
     * @var string[]
     */
    protected $fillable = ['public_mail_id', 'file_path', 'file_size', 'file_type', 'status'];

    /**
     * @return BelongsTo
     */
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class, 'public_mail_id');
    }

    /**
     * @return string
     */
    public function filePath(): string
    {
        return asset($this->file_path);
    }
}
