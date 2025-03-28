<?php

namespace Modules\Attribute\Repositories\AttributeValue;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Attribute\Entities\AttributeValue;

class AttributeValueRepoEloquent implements AttributeValueRepoEloquentInterface
{
    /**
     * @param $property
     * @param $dir
     * @param $relatedId
     * @return Builder
     */
    public function sort($property, $dir, $relatedId): Builder
    {
        return $this->query()->where('attribute_id', $relatedId)->orderBy($property, $dir);
    }

    /**
     * @param $name
     * @return Collection
     */
    public function search($name): Collection
    {
        $result = collect();
        $values = $this->query()->pluck('value');
        foreach ($values as $key => $value) {
            if ($name == json_decode($value)->value) {
                $result->push($this->findById($key));
            }
        }
        return $result;
    }

    /**
     * Get latest categories.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find category by id.
     *
     * @param  $id
     * @return Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete category by id.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Change status by id.
     *
     * @param  $id
     * @param string $status
     * @return int
     */
    public function changeStatus($id, string $status)
    {
        return $this->query()->where('id', $id)->update(['status' => $status]);
    }

    /**
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return AttributeValue::query();
    }
}
