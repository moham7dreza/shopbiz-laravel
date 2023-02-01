<?php

namespace Modules\Share\Traits;

use Modules\Post\Entities\Post;

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

    /**
     * @return array|int|string
     */
    public function postsCount(): array|int|string
    {
        return convertEnglishToPersian($this->posts->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function rolesCount(): array|int|string
    {
        return convertEnglishToPersian($this->roles->count()) ?? 0;
    }


    /**
     * @return array|int|string
     */
    public function usersCount(): array|int|string
    {
        return convertEnglishToPersian($this->users->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function permissionsCount(): array|int|string
    {
        return convertEnglishToPersian($this->permissions->count()) ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function productsCount(): array|int|string
    {
        return convertEnglishToPersian($this->products->count()) ?? 0;
    }

    /**
     * @return string
     */
    public function getAuthorPostsCount(): string
    {
        return convertEnglishToPersian($this->user->posts->count()) ?? 0;
    }

    /**
     * @return int
     */
    public function getAuthorCommentsCount(): int
    {
        return $this->user->comments->count() ?? 0;
    }

    /**
     * @return array|int|string
     */
    public function answersCount(): array|int|string
    {
        return convertEnglishToPersian($this->answers->count()) ?? 0;
    }

    /**
     * @return int
     */
    public function likedPostsCount(): int
    {
        return $this->likes()->withType(Post::class)->count();
    }

    /**
     * @return int
     */
    public function favoritedPostsCount(): int
    {
        return $this->favorites()->withType(Post::class)->count();
    }

    /**
     * @return int
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
    }

    /**
     * @return int
     */
    public function followingsCount(): int
    {
        return $this->followings()->count();
    }

    /**
     * @return int
     */
    public function commentsCount(): int
    {
        return $this->comments->count() ?? 0;
    }
}
