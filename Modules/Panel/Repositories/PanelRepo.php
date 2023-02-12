<?php

namespace Modules\Panel\Repositories;


use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Banner\Repositories\BannerRepoEloquentInterface;
use Modules\Brand\Repositories\BrandRepoEloquentInterface;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Discount\Repositories\AmazingSale\AmazingSaleDiscountRepoEloquentInterface;
use Modules\Discount\Repositories\Common\CommonDiscountRepoEloquentInterface;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;
use Modules\Order\Entities\Order;
use Modules\Order\Repositories\OrderRepoEloquentInterface;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\PaymentRepoEloquentInterface;
use Modules\Payment\Traits\SaleCalculator;
use Modules\Post\Entities\Post;
use Modules\Post\Repositories\PostRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Share\Entities\ActivityLog;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Repositories\Ticket\TicketRepoEloquentInterface;
use Modules\User\Repositories\UserRepoEloquentInterface;

class PanelRepo
{
    use SaleCalculator;

    public UserRepoEloquentInterface $userRepo;
    public PostRepoEloquentInterface $postRepo;
    public CommentRepoEloquentInterface $commentRepo;
    public OrderRepoEloquentInterface $orderRepo;
    public PaymentRepoEloquentInterface $paymentRepo;
    public AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepo;
    public CommonDiscountRepoEloquentInterface $commonDiscountRepo;
    public CopanDiscountRepoEloquentInterface $copanDiscountRepo;
    public TicketRepoEloquentInterface $ticketRepo;
    public SettingRepoEloquentInterface $settingRepo;
    public ProductRepoEloquentInterface $productRepo;
    public BrandRepoEloquentInterface $brandRepo;
    public BannerRepoEloquentInterface $bannerRepo;

    public function __construct(UserRepoEloquentInterface                $userRepoEloquent,
                                PostRepoEloquentInterface                $postRepoEloquent,
                                CommentRepoEloquentInterface             $commentRepoEloquent,
                                OrderRepoEloquentInterface               $orderRepoEloquent,
                                PaymentRepoEloquentInterface             $paymentRepoEloquent,
                                AmazingSaleDiscountRepoEloquentInterface $amazingSaleDiscountRepoEloquent,
                                CommonDiscountRepoEloquentInterface      $commonDiscountRepoEloquent,
                                TicketRepoEloquentInterface              $ticketRepoEloquent,
                                SettingRepoEloquentInterface             $settingRepoEloquent,
                                CopanDiscountRepoEloquentInterface       $copanDiscountRepo,
                                ProductRepoEloquentInterface $productRepo,
                                BrandRepoEloquentInterface $brandRepo,
                                BannerRepoEloquentInterface $bannerRepo)
    {
        $this->userRepo = $userRepoEloquent;
        $this->postRepo = $postRepoEloquent;
        $this->commentRepo = $commentRepoEloquent;
        $this->orderRepo = $orderRepoEloquent;
        $this->paymentRepo = $paymentRepoEloquent;
        $this->amazingSaleDiscountRepo = $amazingSaleDiscountRepoEloquent;
        $this->commonDiscountRepo = $commonDiscountRepoEloquent;
        $this->ticketRepo = $ticketRepoEloquent;
        $this->settingRepo = $settingRepoEloquent;
        $this->copanDiscountRepo = $copanDiscountRepo;
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->bannerRepo = $bannerRepo;
    }

    /**
     * @return int
     */
    public function customersCount(): int
    {
        return $this->userRepo->customerUsersCount();
    }

    /**
     * @return int
     */
    public function adminUsersCount(): int
    {
        return $this->userRepo->adminUsersCount();
    }

    /**
     * @return int
     */
    public function postsCount(): int
    {
        return $this->postRepo->postsCount();
    }

    /**
     * @return int
     */
    public function commentsCount(): int
    {
        return $this->commentRepo->commentsCount();
    }

    /**
     * @return int
     */
    public function ordersCount(): int
    {
        return $this->orderRepo->ordersCount();
    }

    public function paymentsCount(): int
    {
        return $this->paymentRepo->paymentsCount();
    }

    /**
     * @return int
     */
    public function productsCount(): int
    {
        return $this->productRepo->productsCount();
    }

    public function activeAmazingSalesCount(): int
    {
        return $this->amazingSaleDiscountRepo->activeAmazingSalesCount();
    }

    /**
     * @return int
     */
    public function newTicketsCount(): int
    {
        return $this->ticketRepo->newTicketsCount();
    }

    /**
     * @return int
     */
    public function lowCountProducts(): int
    {
        return $this->productRepo->lowMarketableNumber()->count();
    }

    /**
     * @return int
     */
    public function brandsCount(): int
    {
        return $this->brandRepo->index()->count();
    }

    /**
     * @return int
     */
    public function bannersCount(): int
    {
        return $this->bannerRepo->index()->count();
    }

    /**
     * @return Model|Builder|null
     */
    public function activeCommonDiscount(): Model|Builder|null
    {
        return $this->commonDiscountRepo->activeCommonDiscount();
    }

    /**
     * @return Builder|Model|null
     */
    public function activeCopanDiscounts(): Model|Builder|null
    {
        return $this->copanDiscountRepo->activeCopanDiscounts();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function activityLogs(): LengthAwarePaginator
    {
        return ActivityLog::query()->latest()->paginate(5);
//        return ActivityLog::query()->where([['causer_id', '!=', auth()->id()]])->latest()->paginate(5);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function latestComments(): LengthAwarePaginator
    {
        return $this->commentRepo->latestCommentWithoutAdmin()->paginate(3);
    }

    public function lavaColumChart()
    {
        $chart = new Lavacharts();
        $data = $chart->DataTable();
        $data->addStringColumn('سال')
            ->addNumberColumn('تعداد')
            ->addRow(['1390', rand(1000, 9000)])
            ->addRow(['1391', rand(1000, 9000)])
            ->addRow(['1392', rand(1000, 9000)])
            ->addRow(['1393', rand(1000, 9000)])
            ->addRow(['1394', rand(1000, 9000)])
            ->addRow(['1395', rand(1000, 9000)])
            ->addRow(['1396', rand(1000, 9000)])
            ->addRow(['1397', rand(1000, 9000)])
            ->addRow(['1398', rand(1000, 9000)])
            ->addRow(['1399', rand(1000, 9000)])
            ->addRow(['1400', rand(1000, 9000)]);
        $chart->ColumnChart('YearCount', $data, [
            'title' => 'تعداد در سال',
            'titleTextStyle' => [
                'fontSize' => 14,
                'color' => 'green',
                'background' => 'red'
            ],
            'elementId' => 'chart_column',
            'fontName' => 'tahoma'
        ]);
        return $chart;
    }

    /**
     * @return array|string|string[]
     */
    public function lastMonthlySalesAmount(): array|string
    {
        $payments = $this->paymentRepo->index()->get();
        return $this->lastMonthSalesAmount($payments);
    }

    /**
     * @return array|string
     */
    public function lastWeeklySalesAmount(): array|string
    {
        $payments = $this->paymentRepo->index()->get();
        return $this->lastWeekSalesAmount($payments);
    }

    /**
     * @return Builder|Model|null
     */
    public function lastOrder(): Model|Builder|null
    {
        return $this->orderRepo->getLastOrder();
    }

    /**
     * @return int
     */
    public function customerHomeViewCount(): int
    {
        return $this->settingRepo->findById(1)->view_count ?? 0;
    }

    public function browser()
    {
//        return Browser::isDesktop();
    }
}
