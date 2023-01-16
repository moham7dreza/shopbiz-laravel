<?php

namespace Modules\Page\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Page\Entities\Page;

class PageService
{
    /**
     * Store faq.
     *
     * @param  $request
     * @return Model|Builder
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);
    }

    /**
     * Update faq
     *
     * @param  $request
     * @param $page
     * @return mixed
     */
    public function update($request, $page): mixed
    {
        return $page->update([
            'title' => $request->title,
            'body' => $request->body,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Page::query();
    }
}
