<?php

namespace Modules\Share\Traits;

trait HasDefaultStatus
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * @var array|int[]
     */
    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_INACTIVE];

    // text status

    /**
     * @return string
     */
    public function cssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function btnCssStatus(): string
    {
        if ($this->status === self::STATUS_ACTIVE) return 'danger';
        else if ($this->status === self::STATUS_INACTIVE) return 'success';
        else return 'warning';
    }

    /**
     * @return string
     */
    public function textStatus(): string
    {
        return $this->status === self::STATUS_ACTIVE ? 'فعال' : 'غیر فعال';
    }

    /**
     * @return int
     */
    public function active(): int
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * @return int
     */
    public function inActive(): int
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    /**
     * @return int
     */
    public function statusActive(): int
    {
        return self::STATUS_ACTIVE;
    }

    /**
     * @return int
     */
    public function statusInActive(): int
    {
        return self::STATUS_INACTIVE;
    }

    /**
     * @param $query
     * @param int $status
     * @return mixed
     */
    public function scopeActive($query, int $status = self::STATUS_ACTIVE): mixed
    {
        return $query->where('status', $status);
    }
}
