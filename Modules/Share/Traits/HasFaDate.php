<?php

namespace Modules\Share\Traits;

trait HasFaDate
{
    public function getDiffCreatedDate(): string
    {
        return $this->created_at->diffForHumans() ?? $this->getFaCreatedDate();
    }

    public function getDiffUpdatedDate(): string
    {
        return $this->updated_at->diffForHumans() ?? $this->getFaUpdatedDate();
    }

    public function getFaCreatedDate(): string
    {
        return jalaliDate($this->created_at);
    }

    public function getFaUpdatedDate(): string
    {
        return jalaliDate($this->updated_at);
    }
}
