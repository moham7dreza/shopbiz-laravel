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
}
