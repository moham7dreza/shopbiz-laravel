<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Share\Traits\HasDefaultStatus;
use Modules\User\Entities\User;

class TicketFile extends Model
{
    use HasFactory, SoftDeletes, HasDefaultStatus;

    /**
     * @var string[]
     */
    protected $fillable = ['ticket_id', 'user_id', 'file_path', 'file_size', 'file_type', 'status'];

    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
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
