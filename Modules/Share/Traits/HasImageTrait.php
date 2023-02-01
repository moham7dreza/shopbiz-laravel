<?php

namespace Modules\Share\Traits;

trait HasImageTrait
{
    /**
     * @return string
     */
    public function image(): string
    {
        return asset($this->image);
    }

    /**
     * @param string $size
     * @return string
     */
    public function imagePath(string $size = 'medium'): string
    {
        return asset($this->image['indexArray'][$size]);
    }

    /**
     * @return string
     */
    public function logo(): string
    {
        return asset($this->logo);
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return asset($this->icon);
    }

    /**
     * @param string $size
     * @return string
     */
    public function productImagePath(string $size = 'medium'): string
    {
        return asset($this->product->image['indexArray'][$size]);
    }

    /**
     * @return string
     */
    public function authorImage(): string
    {
        return $this->user->image() ?? 'عکس ندارد.';
    }

    /**
     * @return string
     */
    public function profile(): string
    {
        return asset($this->profile_photo_path);
    }
}
