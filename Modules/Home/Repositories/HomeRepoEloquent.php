<?php

namespace Modules\Home\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Banner\Entities\Banner;
use Modules\Brand\Entities\Brand;
use Modules\Comment\Entities\Comment;
use Modules\Discount\Entities\AmazingSale;
use Modules\Post\Entities\Post;
use Modules\Product\Entities\Product;
use Modules\Setting\Entities\Setting;

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
     * @return Builder[]|Collection
     */
    public function bottomMiddleBanners()
    {
        return Banner::query()->where('position', 3)->where('status', 1)->take(2)->get();
    }
    /**
     * @return Builder|Model|object|null
     */
    public function bottomBanner()
    {
        return Banner::query()->where('position', 4)->where('status', 1)->first();
    }

    /**
     * @return Builder|Model|object|null
     */
    public function brandsBanner()
    {
        return Banner::query()->where('position', 5)->where('status', 1)->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function fourColumnBanners()
    {
        return Banner::query()->where('position', 6)->where('status', 1)->take(4)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function brands()
    {
        return Brand::query()->latest()->get();
    }

    /**
     *         // پربازدید ترین کالاها
     * @return Builder[]|Collection
     */
    public function mostVisitedProducts()
    {
        return Product::query()->latest()->take(10)->get();
    }

    /**
     *         // کالاهای پیشنهادی
     * @return Builder[]|Collection
     */
    public function offerProducts()
    {
        return Product::query()->latest()->take(10)->get();
    }

    /**
     * فروش ویژه هفته
     * @return Builder[]|Collection
     */
    public function weeklyAmazingSales()
    {
        return AmazingSale::query()->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())->where('status', 1)->
            where('percentage', '>=', 5)->take(10)->get();
    }

    /**
     *         // جدید ترین کالاها
     * @return Builder[]|Collection
     */
    public function newestProducts()
    {
        return Product::query()->latest()->take(10)->get();
    }

    /**
     *         // نظرات کاربران
     * @return Builder[]|Collection
     */
    public function latestComments()
    {
        return Comment::query()->where('parent_id', null)->where('status', 1)->latest()->take(10)->get();
    }

    /**
     *         // جدید ترین مقالات
     * @return Builder[]|Collection
     */
    public function posts()
    {
        return Post::query()->where('status', 1)->take(5)->get();
    }

    /**
     *         // محصولات فروش ویژه
     * @return Builder[]|Collection
     */
    public function productsWithActiveAmazingSales()
    {
        return AmazingSale::query()->where('start_date', '<', Carbon::now())
            ->where('end_date', '>', Carbon::now())->where('status', 1)->
            where('percentage', '>=', 1)->take(10)->get();
    }

    /**
     *         // تنطیمات سایت
     * @return Builder|Collection|Model|null
     */
    public function siteSetting()
    {
        return Setting::query()->find(1);
    }

    /**
     *
     *         // پرفروش ترین محصولات
     * @return Builder[]|Collection
     */
    public function bestSellerProducts()
    {
        return Product::query()->where('sold_number', '>=', 100)->take(10)->get();
    }
}
