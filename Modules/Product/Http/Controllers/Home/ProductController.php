<?php

namespace Modules\Product\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Comment\Entities\Comment;
use Modules\Product\Entities\Product;
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function addComment(Product $product, Request $request): RedirectResponse
    {
        $request->validate([
            'body' => 'required|max:2000'
        ]);

        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = Product::class;
        Comment::query()->create($inputs);
        return back();
    }


    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function addToFavorite(Product $product): JsonResponse
    {
        if (Auth::check()) {
            $product->user()->toggle([Auth::user()->id]);
            if ($product->user->contains(Auth::user()->id)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }
}
