<?php

namespace Modules\Product\Services\Product;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;
use Modules\Product\Repositories\ProductColor\ProductColorRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Product\Services\Meta\ProductMetaServiceInterface;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ReviewService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductService implements ProductServiceInterface
{
    use ShowMessageWithRedirectTrait;

    public ImageService $imageService;
    public ProductMetaServiceInterface $metaService;
    public ReviewService $reviewService;
    public ProductRepoEloquentInterface $productRepo;
    public SettingRepoEloquentInterface $settingRepo;
    public ProductColorRepoEloquentInterface $productColorRepo;

    /**
     * @param ImageService $imageService
     * @param ProductMetaServiceInterface $metaService
     * @param ReviewService $reviewService
     * @param ProductRepoEloquentInterface $productRepo
     * @param SettingRepoEloquentInterface $settingRepo
     * @param ProductColorRepoEloquentInterface $productColorRepo
     */
    public function __construct(ImageService $imageService,
                                ProductMetaServiceInterface $metaService,
                                ReviewService $reviewService,
                                ProductRepoEloquentInterface $productRepo,
                                SettingRepoEloquentInterface $settingRepo,
                                ProductColorRepoEloquentInterface $productColorRepo)
    {
        $this->imageService = $imageService;
        $this->metaService = $metaService;
        $this->reviewService = $reviewService;
        $this->productRepo = $productRepo;
        $this->settingRepo = $settingRepo;
        $this->productColorRepo = $productColorRepo;
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function productAddToFavorite(Product $product): JsonResponse
    {
        $user = auth()->user();
        if (auth()->check()) {
            $user->toggleFavorite($product);
            if ($user->hasFavorited($product)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }

    /**
     * @param $cartItems
     * @return void
     */
    public function decreaseProductsCounters($cartItems): void
    {
        $setting = $this->settingRepo->getSystemSetting();
        foreach ($cartItems as $cartItem) {
            $product = $this->productRepo->findById($cartItem->product_id);
            $product->frozen_number -= $cartItem->number;
            $product->marketable_number -= $cartItem->number;
            $product->sold_number += $cartItem->number;
            $product->save();
            // if product has color
            if (!is_null($cartItem->color_id)) {
                $productSelectedColor = $this->productColorRepo->findById($cartItem->color_id);
                $productSelectedColor->frozen_number -= $cartItem->number;
                $productSelectedColor->marketable_number -= $cartItem->number;
                $productSelectedColor->sold_number += $cartItem->number;
                $productSelectedColor->save();
            }
            if ($product->marketable_number < 10) {
                $setting->low_count_products += 1;
                $setting->save();
            }
        }
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function productLike(Product $product): JsonResponse
    {
        $user = auth()->user();
        if (auth()->check()) {
            $user->toggleLike($product);
            if ($user->hasLiked($product)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }

    /**
     * @param Product $product
     * @param int $rate
     * @return JsonResponse
     */
    public function productReview(Product $product, int $rate): JsonResponse
    {
        if (auth()->check()) {
            $this->reviewService->store($product, $rate);
            return response()->json(['status' => $rate]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    /**
     * @param $request
     * @param $product
     * @return mixed
     */
    public function updateProductStore($request, $product): mixed
    {
        return $product->update([
            'sold_number' => $request->sold_number,
            'frozen_number' => $request->frozen_number,
            'marketable_number' => $request->marketable_number,
        ]);
    }

    /**
     * @param $product
     * @param $request
     * @return void
     */
    public function productAddToStore($request, $product): void
    {
        $product->marketable_number += $request->marketable_number;
        $product->save();
        Log::info('warehouse updated', (array)"receiver => {$request->receiver}, deliverer => {$request->deliverer}, description => {$request->description}, add => {$request->marketable_number}");
    }

    /**
     * @param $request
     * @return string
     */
    public function store($request): string
    {
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('product', $request->file('image'), $this->imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            $request->image = null;
        }

        DB::transaction(function () use ($request) {

            $product = $this->query()->create([
                'name' => $request->name,
                'code_kala' => 'shop-product-' . convertEnglishToPersian(mt_rand(100000, 999999)),
                'introduction' => $request->introduction,
                'image' => $request->image,
                'status' => $request->status,
                'weight' => $request->weight,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'price' => $request->price,
                'marketable' => $request->marketable,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'published_at' => ShareService::realTimestampDateFormat($request->published_at),
            ]);
            $this->storeProductMetas($product->id, $request->meta_key, $request->meta_value);
        });
        return 'done';
    }

    /**
     * @param $productId
     * @param $metaKey
     * @param $metaValue
     * @return void
     */
    public function storeProductMetas($productId, $metaKey, $metaValue): void
    {
        $metas = array_combine($metaKey, $metaValue);
        foreach ($metas as $key => $value) {
            $meta = $this->metaService->store($productId, $key, $value);
        }
    }

    /**
     * @param $request
     * @param $product
     * @return string
     */
    public function update($request, $product): string
    {
        if ($request->hasFile('image')) {
            if (!empty($product->image)) {
                $this->imageService->deleteDirectoryAndFiles($product->image['directory']);
            }
            $result = ShareService::createIndexAndSaveImage('product', $request->file('image'), $this->imageService);

            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            if (isset($request->currentImage) && !empty($product->image)) {
                $image = $product->image;
                $image['currentImage'] = $request->currentImage;
                $request->image = $image;
            } else {
                $request->image = $product->image;
            }
        }

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'name' => $request->name,
                'introduction' => $request->introduction,
                'image' => $request->image,
                'status' => $request->status,
                'weight' => $request->weight,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'price' => $request->price,
                'marketable' => $request->marketable,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'published_at' => ShareService::realTimestampDateFormat($request->published_at),
            ]);
            $this->updateProductMetas($request->meta_key, $request->meta_value);
        });
        return 'done';
    }

    /**
     * @param $meta_keys
     * @param $meta_values
     * @return void
     */
    private function updateProductMetas($meta_keys, $meta_values): void
    {
        if (!is_null($meta_keys)) {
            $meta_ids = array_keys($meta_keys);
            $metas = array_map(function ($meta_id, $meta_key, $meta_value) {
                return array_combine(
                    ['meta_id', 'meta_key', 'meta_value'],
                    [$meta_id, $meta_key, $meta_value]
                );
            }, $meta_ids, $meta_keys, $meta_values);
            foreach ($metas as $meta) {
                $this->metaService->update($meta['meta_id'], $meta['meta_key'], $meta['meta_value']);
            }
        }
    }

//    /**
//     * Store product with request.
//     *
//     * @param  array $data
//     * @return Builder|\Illuminate\Database\Eloquent\Model
//     * @throws \Exception
//     */
//    public function store(array $data)
//    {
//        return $this->query()->create([
//            'vendor_id'         => auth()->id(),
//            'slug'              => ShareService::makeSlug($data['title']),
//            'sku'               => ShareService::makeUniqueSku(Product::class),
//            'first_media_id'    => $data['first_media_id'],
//            'title'             => $data['title'],
//            'price'             => $data['price'],
//            'count'             => $data['count'],
//            'type'              => $data['type'],
//            'short_description' => $data['short_description'],
//            'body'              => $data['body'],
//            'status'            => $data['status'],
//            'is_popular'        => $data['is_popular'],
//        ]);
//    }
//
//    /**
//     * Update product with request by id.
//     *
//     * @param  $request
//     * @param  $id
//     * @return mixed
//     */
//    public function update($request, $id)
//    {
//        return $this->query()->whereId($id)->update([
//            'first_media_id'    => $request->first_media_id,
//            'title'             => $request->title,
//            'slug'              => ShareService::makeSlug($request->title),
//            'price'             => $request->price,
//            'count'             => $request->count,
//            'type'              => $request->type,
//            'short_description' => $request->short_description,
//            'body'              => $request->body,
//            'status'            => $request->status,
//            'is_popular'        => $request->is_popular,
//        ]);
//    }
//
//    /**
//     * Attach categories to product.
//     *
//     * @param  $categories
//     * @param  $product
//     * @return void
//     */
//    public function attachCategoriesToProduct($categories, $product)
//    {
//        foreach ($categories as $category) {
//            $product->categories()->attach($category);
//        }
//    }
//
//    /**
//     * Attach categories to product.
//     *
//     * @param  $galleries
//     * @param  $product
//     * @return void
//     */
//    public function attachGalleriesToProduct($galleries, $product)
//    {
//        foreach ($galleries as $gallery) {
//            $product->galleries()->attach(MediaFileService::publicUpload($gallery)->id);
//        }
//    }
//
//    /**
//     * Attach attributes to product.
//     *
//     * @param  $attributes
//     * @param  $product
//     * @return void
//     */
//    public function attachAttributesToProduct($attributes, $product)
//    {
//        foreach ($attributes as $attribute) {
//            $product->attachAttribute($attribute['attributekeys'], $attribute['attributevalues']);
//        }
//    }
//
//    /**
//     * Attach tags to product.
//     *
//     * @param  array $tags
//     * @param  $product
//     * @return mixed
//     */
//    public function attachTagsToProduct(array $tags, $product)
//    {
//        return $product->attachTags($tags);
//    }
//
//    /**
//     * First or create categories product.
//     *
//     * @param  array $categories
//     * @param  $product
//     * @return void
//     */
//    public function firstOrCreateCategoriesToProduct(array $categories, $product)
//    {
//        foreach ($categories as $category) {
//            $product->categories()->syncWithoutDetaching($category);
//        }
//    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Product::query();
    }
}
