<?php

namespace Modules\Product\Http\Controllers\Home;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Comment\Services\CommentService;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\Home\AddCommentToProductRequest;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Product\ProductService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public ProductRepoEloquentInterface $repo;
    public ProductService $service;

    public CartRepoEloquentInterface $cartRepo;

    /**
     * @param ProductRepoEloquentInterface $productRepoEloquent
     * @param ProductService $productService
     * @param CartRepoEloquentInterface $cartRepo
     */
    public function __construct(ProductRepoEloquentInterface $productRepoEloquent, ProductService $productService, CartRepoEloquentInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->repo = $productRepoEloquent;
        $this->service = $productService;
    }

    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function product(Product $product): View|Factory|Application
    {
        $this->setMetas($product);
        views($product)->record();
        $relatedProducts = $this->repo->relatedItems($product)->get();
        $userCartItemsProductIds = $this->cartRepo->findUserCartItems()->pluck('product_id')->all();
        return view('Product::home.product', compact(['product', 'relatedProducts', 'userCartItemsProductIds']));
    }

    /**
     * @param Product $product
     * @param AddCommentToProductRequest $request
     * @param CommentService $commentService
     * @return RedirectResponse
     */
    public function addComment(Product $product, AddCommentToProductRequest $request, CommentService $commentService): RedirectResponse
    {
        if (!auth()->check()) {
            return $this->showAlertWithRedirect(message: 'برای ثبت نظر بایستی عضوی از وبسایت ما باشید.', title: 'خطا', type: 'error');
//            return back()->with('swal-animate', 'برای ثبت نظر بایستی عضوی از وبسایت ما باشید.');
        }
        $commentService->store($request, $product);
        if (ShareService::checkForAdmin()) {
            return $this->showToastWithRedirect(title: 'نظر شما با موفقیت ثبت شد.');
            //            return back()->with('swal-timer', 'نظر شما با موفقیت ثبت شد.');
        }
//        return back()->with('swal-animate', 'نظر شما با موفقیت ثبت شد. پس از تایید در سایت قرار خواهد گرفت.');
        return $this->showAlertWithRedirect(message: 'نظر شما با موفقیت ثبت شد پس از تایید در سایت قرار خواهد گرفت.');
    }


    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addToFavorite(Product $product): JsonResponse
    {
        return $this->service->productAddToFavorite($product);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function like(Product $product): JsonResponse
    {
        return $this->service->productLike($product);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function review(Product $product): JsonResponse
    {
        return $this->service->productReview($product, request()->rate);
    }

    /**
     * @param $product
     * @return void
     */
    private function setMetas($product): void
    {
        SEOMeta::setTitle($product->name);
        SEOMeta::setDescription($product->getTagLessIntroduction());
        SEOMeta::addMeta('product:published_time', $product->published_date, 'property');
        SEOMeta::addMeta('product:section', $product->getCategoryName(), 'property');
        SEOMeta::addKeyword($product->tags ?? '');

        OpenGraph::setDescription($product->getTagLessIntroduction());
        OpenGraph::setTitle($product->name);
        OpenGraph::setUrl('http://current.url.com');
        OpenGraph::addProperty('type', 'product');
        OpenGraph::addProperty('locale', 'fa-ir');
        OpenGraph::addProperty('locale:alternate', ['fa-ir', 'en-us']);

        OpenGraph::addImage($product->imagePath());
        OpenGraph::addImage(['url' => 'http://image.url.com/cover.jpg', 'size' => 300]);
        OpenGraph::addImage('http://image.url.com/cover.jpg', ['height' => 300, 'width' => 300]);

        JsonLd::setTitle($product->name);
        JsonLd::setDescription($product->getTagLessIntroduction());
        JsonLd::setType('Product');
        JsonLd::addImage($product->imagePath());

        // Namespace URI: http://ogp.me/ns/article#
        // article
        OpenGraph::setTitle('Product')
            ->setDescription($product->getTagLessIntroduction())
            ->setType('product')
            ->setArticle([
                'published_time' => $product->published_date,
                'modified_time' => $product->updated_at,
                'author' => 'profile / array',
                'section' => 'string',
                'tag' => $product->tags
            ]);
    }
}
