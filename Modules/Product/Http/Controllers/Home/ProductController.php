<?php

namespace Modules\Product\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Comment\Services\CommentService;
use Modules\Product\Entities\Product;
use Modules\Product\Http\Requests\Home\AddCommentToProductRequest;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Product\ProductService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;

class ProductController extends Controller
{
    public ProductRepoEloquentInterface $repo;
    public ProductService $service;

    /**
     * @param ProductRepoEloquentInterface $productRepoEloquent
     * @param ProductService $productService
     */
    public function __construct(ProductRepoEloquentInterface $productRepoEloquent, ProductService $productService)
    {
        $this->repo = $productRepoEloquent;
        $this->service = $productService;
    }

    /**
     * @param Product $product
     * @return Application|Factory|View
     */
    public function product(Product $product): View|Factory|Application
    {
        $relatedProducts = $this->repo->index()->get();
        return view('Product::home.product', compact(['product', 'relatedProducts']));
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
            return back()->with('swal-animate', 'برای ثبت نظر بایستی عضوی از وبسایت ما باشید.');
        }
        $commentService->store($request, $product);
        if (ShareService::checkForAdmin())
            return back()->with('swal-timer', 'نظر شما با موفقیت ثبت شد.');
        return back()->with('swal-animate', 'نظر شما با موفقیت ثبت شد. پس از تایید در سایت قرار خواهد گرفت.');
    }


    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addToFavorite(Product $product): JsonResponse
    {
        return $this->service->productAddToFavorite($product);
    }
}
