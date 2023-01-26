<?php

namespace Modules\Notify\Repositories\EmailFile;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Entities\EmailFile;

class EmailFileRepoEloquent implements EmailFileRepoEloquentInterface
{
    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('file_size', $name)->orWhere('file_type' , 'like', '%' . $name . '%')->latest();
    }

    /**
     * Get latest products.
     *
     * @return Builder
     */
    public function getLatest(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * Find product by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id): Model|Collection|Builder|array|null
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete product by id.
     *
     * @param  $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * Get query model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return EmailFile::query();
    }
}
