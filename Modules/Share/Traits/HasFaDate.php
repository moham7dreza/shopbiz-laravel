<?php

namespace Modules\Share\Traits;

trait HasFaDate
{
    /**
     * @return string
     */
    public function getDiffCreatedDate(): string
    {
        return $this->created_at->diffForHumans() ?? $this->getFaCreatedDate();
    }

    /**
     * @return string
     */
    public function getDiffUpdatedDate(): string
    {
        return $this->updated_at->diffForHumans() ?? $this->getFaUpdatedDate();
    }

    /**
     * @return string
     */
    public function getFaCreatedDate(): string
    {
        return jalaliDate($this->created_at) ?? $this->created_at;
    }

    /**
     * @return string
     */
    public function getFaUpdatedDate(): string
    {
        return jalaliDate($this->updated_at) ?? $this->updated_at;
    }

    /**
     * @param $date
     * @param string|null $format
     * @return string
     */
    public function getFaDate($date, string $format = null): string
    {
        return jalaliDate($date, $format) ?? $date ?? '-';
    }

    /**
     * @param $date
     * @return string
     */
    public function getDiffDate($date): string
    {
        return $date->diffForHumans() ?? $this->getFaDate($date);
    }

    /**
     * @return mixed|string
     */
    public function getFaStartDate(): mixed
    {
        return $this->getFaDate($this->start_date);
    }

    /**
     * @return mixed|string
     */
    public function getFaEndDate(): mixed
    {
        return $this->getFaDate($this->end_date);
    }

    /**
     * @return mixed|string
     */
    public function publishFaDateWithTime(): mixed
    {
        return $this->getFaDate($this->published_at, 'H:i:s | Y-m-d');
    }
}
