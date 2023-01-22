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
use Modules\Share\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * @param Product $product
     * @param ProductRepoEloquentInterface $productRepo
     * @return Application|Factory|View
     */
    public function product(Product $product, ProductRepoEloquentInterface $productRepo): View|Factory|Application
    {
        $relatedProducts = $productRepo->index()->get();
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
            return back()->with('error', 'برای ثبت نظر بایستی عضوی از وبسایت ما باشید.');
        }
        $commentService->store($request, $product);
        if ($commentService->checkForAdmin())
            return back()->with('success', 'نظر شما با موفقیت ثبت شد.');
        return back()->with('success', 'نظر شما با موفقیت ثبت شد. پس از تایید در سایت قرار خواهد گرفت.');
    }


    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addToFavorite(Product $product): JsonResponse
    {
        if (auth()->check()) {
            $product->user()->toggle([auth()->id()]);
            if ($product->user->contains(auth()->id())) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }
}
