<?php

namespace Modules\Product\Services\Guarantee;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Entities\Guarantee;

class GuaranteeService implements GuaranteeServiceInterface
{
    /**
     * Store guarantee.
     *
     * @param  $request
     * @return Builder|Model|RedirectResponse
     */
    public function store($request): Model|Builder|RedirectResponse
    {
        return $this->query()->create([
            'name' => $request->name,
            'default_duration' => $request->default_duration,
            'status' => $request->status,
            'website_link' => $request->website_link,
        ]);
    }

    /**
     * @param $request
     * @param $guarantee
     * @return mixed
     */
    public function update($request, $guarantee): mixed
    {
        return $guarantee->update([
            'name' => $request->name,
            'default_duration' => $request->default_duration,
            'status' => $request->status,
            'website_link' => $request->website_link,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Guarantee::query();
    }
}
