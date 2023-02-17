<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Share\Traits\HasFaDate;
use Modules\Share\Traits\HasDefaultStatus;

use Modules\User\Entities\User;

class Ticket extends Model
{
    use HasFactory, SoftDeletes, HasFaDate;

    public const STATUS_OPEN_TICKET = 1;
    public const STATUS_CLOSE_TICKET = 0;
    public const STATUS_SEEN_TICKET = 1;
    public const STATUS_UN_SEEN_TICKET = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_OPEN_TICKET, self::STATUS_CLOSE_TICKET];

    /**
     * @var string[]
     */
    protected $fillable = ['subject', 'description', 'status', 'seen', 'reference_id', 'user_id', 'category_id', 'priority_id', 'ticket_id'];


    // ********************************************* Relations

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(TicketAdmin::class, 'reference_id');
    }

    /**
     * @return BelongsTo
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(TicketPriority::class);
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TicketCategory::class);
    }


    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo($this, 'ticket_id')->with('parent');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'ticket_id')->with('children');
    }

    // ********************************************* Methods

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user->fullName ?? $this->user->first_name ?? '-';
    }

    /**
     * @return string
     */
    public function getParentTitle(): string
    {
        return !empty($this->parent->subject) ? Str::limit($this->parent->subject, 50) : '-';
    }

    /**
     * @return string
     */
    public function getReferenceName(): string
    {
        return $this->admin->user->fullName ?? $this->admin->user->first_name ?? '-';
    }

    /**
     * @param int $size
     * @return string
     */
    public function getLimitedSubject(int $size = 50): string
    {
        return Str::limit($this->subject, $size);
    }

    /**
     * @return string
     */
    public function getCategoryName(): string
    {
        return $this->category->name ?? 'دسته ندارد';
    }

    /**
     * @return string
     */
    public function getPriorityName(): string
    {
        return $this->priority->name ?? 'اولویت ندارد';
    }

    // ********************************************* css


    /**
     * @return string
     */
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_OPEN_TICKET) return 'danger';
        else if ($this->status === self::STATUS_CLOSE_TICKET) return 'success';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function iconStatus(): string
    {
        if ($this->status === self::STATUS_OPEN_TICKET) return 'times';
        else if ($this->status === self::STATUS_CLOSE_TICKET) return 'check';
        else return 'warning';
    }

    // ********************************************* FA Properties

    /**
     * @return array|string
     */
    public function getFaId(): array|string
    {
        return convertEnglishToPersian($this->id);
    }
}
