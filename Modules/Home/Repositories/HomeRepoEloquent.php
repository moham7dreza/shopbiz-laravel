<?php

namespace Modules\Home\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;
use Modules\Brand\Entities\Brand;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\PostRepoEloquentInterface;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;

class HomeRepoEloquent implements HomeRepoEloquentInterface
{
    private BannerRepoEloquentInterface $bannerRepo;
    private BrandRepoEloquentInterface $brandRepo;
    private ProductRepoEloquentInterface $productRepo;
    private AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo;
    private CommentRepoEloquentInterface $commentRepo;
    private PostRepoEloquentInterface $postRepo;
    private SettingRepoEloquentInterface $settingRepo;

    public function __construct(BannerRepoEloquentInterface              $bannerRepo,
                                BrandRepoEloquentInterface               $brandRepo,
                                ProductRepoEloquentInterface             $productRepo,
                                AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo,
                                CommentRepoEloquentInterface             $commentRepo,
                                PostRepoEloquentInterface                $postRepo,
                                SettingRepoEloquentInterface             $settingRepo)
    {
        $this->bannerRepo = $bannerRepo;
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
        $this->amazingSaleDiscountRepo = $amazingSaleDiscountRepo;
        $this->commentRepo = $commentRepo;
        $this->postRepo = $postRepo;
        $this->settingRepo = $settingRepo;
    }

    /**
     * @return Builder[]|Collection
     */
    public function slideShowImages(): Collection|array
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_SLIDE_SHOW)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function topBanners(): Collection|array
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_INSIDE_SLIDE_SHOW)->take(2)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function middleBanners(): Collection|array
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_2_MIDDLE_BANNERS)->take(2)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function bottomMiddleBanners(): Collection|array
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_2_BOTTOM_BANNERS)->take(2)->get();
    }

    /**
     * @return Model|Builder|null
     */
    public function bottomBanner(): Model|Builder|null
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_BIG_BOTTOM_BANNER)->first();
    }

    /**
     * @return Model|Builder|null
     */
    public function brandsBanner(): Model|Builder|null
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_BIG_BRANDS_BANNER)->first();
    }

    /**
     * @return Builder[]|Collection
     */
    public function fourColumnBanners(): Collection|array
    {
        return $this->bannerRepo->getActiveBannerByPosition(Banner::POSITION_4_MIDDLE_BANNERS)->take(4)->get();
    }

    /**
     * @return Builder[]|Collection
     */
    public function brands(): Collection|array
    {
        return $this->brandRepo->getActiveBrands()->get();
    }

    /**
     *         // پربازدید ترین کالاها
     * @return Builder[]|Collection
     */
    public function mostVisitedProducts(): Collection|array
    {
        return $this->productRepo->index()->take(10)->get();
    }

    /**
     *         // کالاهای پیشنهادی
     * @return Builder[]|Collection
     */
    public function offerProducts(): Collection|array
    {
        return $this->productRepo->index()->take(10)->get();
    }

    /**
     * فروش ویژه هفته
     * @return Builder[]|Collection
     */
    public function weeklyAmazingSales(): Collection|array
    {
        return $this->amazingSaleDiscountRepo->bestOffers(5)->take(10)->get();
    }

    /**
     *         // جدید ترین کالاها
     * @return Builder[]|Collection
     */
    public function newestProducts(): Collection|array
    {
        return $this->productRepo->index()->take(10)->get();
    }

    /**
     *         // نظرات کاربران
     * @return Builder[]|Collection
     */
    public function latestComments(): Collection|array
    {
        return $this->commentRepo->latestActiveParentComments()->take(10)->get();
    }

    /**
     *         // جدید ترین مقالات
     * @return Builder[]|Collection
     */
    public function posts(): Collection|array
    {
        return $this->postRepo->home()->take(5)->get();
    }

    /**
     *         // محصولات فروش ویژه
     * @return Builder[]|Collection
     */
    public function productsWithActiveAmazingSales(): Collection|array
    {
        return $this->amazingSaleDiscountRepo->bestOffers(1)->take(10)->get();
    }

    /**
     *         // تنطیمات سایت
     * @return Builder|Collection|Model|null
     */
    public function siteSetting(): Model|Collection|Builder|null
    {
        return $this->settingRepo->findById(1);
    }

    /**
     *
     *         // پرفروش ترین محصولات
     * @return Builder[]|Collection
     */
    public function bestSellerProducts(): Collection|array
    {
        return $this->productRepo->bestSeller(100)->take(10)->get();
    }
}
