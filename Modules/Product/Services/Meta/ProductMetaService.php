<?php

namespace Modules\Product\Services\Meta;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\ProductMeta;
use Modules\Product\Repositories\Meta\ProductMetaRepoEloquentInterface;

class ProductMetaService implements ProductMetaServiceInterface
{
    public ProductMetaRepoEloquentInterface $productMetaRepo;

    public function __construct(ProductMetaRepoEloquentInterface $productMetaRepo)
    {
        $this->productMetaRepo = $productMetaRepo;
    }

    /**
     * @param $productId
     * @param $metaKey
     * @param $metaValue
     * @return Builder|Model
     */
    public function store($productId, $metaKey, $metaValue): Model|Builder
    {
        return $this->query()->create([
            'meta_key' => $metaKey,
            'meta_value' => $metaValue,
            'product_id' => $productId
        ]);
    }


    /**
     * @param $id
     * @param $metaKey
     * @param $metaValue
     * @return bool|int
     */
    public function update($id, $metaKey, $metaValue): bool|int
    {
        $meta = $this->productMetaRepo->findById($id);
        return $meta->update([
            'meta_key' => $metaKey,
            'meta_value' => $metaValue
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return ProductMeta::query();
    }
}
