<?php

namespace Modules\Faq\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Faq\Entities\Faq;

class FaqService
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
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status,
            'tags' => $request->tags,
        ]);
    }

    /**
     * Update faq
     *
     * @param  $request
     * @param $faq
     * @return mixed
     */
    public function update($request, $faq): mixed
    {
        return $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
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
        return Faq::query();
    }
}
