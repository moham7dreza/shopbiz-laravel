<?php

namespace Modules\Share\Traits;

trait HasCountersTrait
{
    // Counters

    /**
     * @return array|int|string
     */
    public function getFaViewsCount(): array|int|string
    {
        return convertEnglishToPersian(views($this)->unique()->count()) ?? 0;
    }

    public function likersCount(): int
    {
        return $this->likers()->count();
    }

    public function favoritersCount(): int
    {
        return $this->favoriters()->count();
    }
}
