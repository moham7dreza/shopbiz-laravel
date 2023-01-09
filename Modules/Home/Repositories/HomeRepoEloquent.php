<?php

namespace Modules\Home\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Banner\Entities\Banner;
use Modules\Brand\Entities\Brand;
use Modules\Product\Entities\Product;

class HomeRepoEloquent implements HomeRepoEloquentInterface
{
    /**
     * @return Builder[]|Collection
     */
    public function slideShowImages()
    {
        return Banner::query()->where('position', 0)->where('status', 1)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function topBanners()
    {
        return Banner::query()->where('position', 1)->where('status', 1)->take(2)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function middleBanners()
    {
        return Banner::query()->where('position', 2)->where('status', 1)->take(2)->get();
    }

    /**
     * @return Builder|Model|object|null
     */
    public function bottomBanner()
    {
        return Banner::query()->where('position', 3)->where('status', 1)->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function brands()
    {
        return Brand::query()->latest()->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function mostVisitedProducts()
    {
        return Product::query()->latest()->take(10)->get();
    }

    public function offerProducts()
    {
        return Product::query()->latest()->take(10)->get();
    }
    /**
     * Get the latest roles with permissions.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->with('permissions')->latest();
    }

    /**
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete role by id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Get all permissions.
     *
     * @return Collection
     */
    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Faq::query();
    }
}
