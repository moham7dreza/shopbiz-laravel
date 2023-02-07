<?php

namespace Modules\Post\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Post\Entities\Post;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PostService implements PostServiceInterface
{

    use ShowMessageWithRedirectTrait;

    public ImageService $imageService;

    /**
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Store category.
     *
     * @param  $request
     * @return Builder|Model|RedirectResponse
     */
    public function store($request): Model|Builder|RedirectResponse
    {
        if ($request->hasFile('image')) {
            $result = ShareService::createIndexAndSaveImage('post', $request->file('image'), $this->imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            $request->image = null;
        }

        return $this->query()->create([
            'title' => $request->title,
            'summary' => $request->summary,
            'image' => $request->image,
            'status' => $request->status,
            'body' => $request->body,
            'published_at' => ShareService::realTimestampDateFormat($request->published_at),
            'author_id' => auth()->id(),
            'category_id' => $request->category_id,
            'commentable' => $request->commentable,
        ]);
    }

    /**
     * @param $request
     * @param $post
     * @return mixed
     */
    public function update($request, $post): mixed
    {
        if ($request->hasFile('image')) {
            if (!empty($post->image)) {
                $this->imageService->deleteDirectoryAndFiles($post->image['directory']);
            }
            $result = ShareService::createIndexAndSaveImage('post', $request->file('image'), $this->imageService);

            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            if (isset($request->currentImage) && !empty($post->image)) {
                $image = $post->image;
                $image['currentImage'] = $request->currentImage;
                $request->image = $image;
            } else {
                $request->image = $post->image;
            }
        }

        return $post->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'image' => $request->image,
            'status' => $request->status,
            'body' => $request->body,
            'published_at' => ShareService::realTimestampDateFormat($request->published_at),
            'author_id' => auth()->id(),
            'category_id' => $request->category_id,
            'commentable' => $request->commentable,
        ]);
    }


    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function postAddToFavorite(Post $post): JsonResponse
    {
        $user = auth()->user();
        if (auth()->check()) {
            $user->toggleFavorite($post);
            if ($user->hasFavorited($post)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function productLike(Post $post): JsonResponse
    {
        $user = auth()->user();
        if (auth()->check()) {
            $user->toggleLike($post);
            if ($user->hasLiked($post)) {
                return response()->json(['status' => 1]);
            } else {
                return response()->json(['status' => 2]);
            }
        } else {
            return response()->json(['status' => 3]);
        }
    }

//    /**
//     * Store article by request.
//     *
//     * @param  $request
//     * @return Builder|\Illuminate\Database\Eloquent\Model
//     */
//    public function store($request)
//    {
//        $title = $request->title;
//        $body = $request->body;
//
//        return $this->query()->create([
//            'user_id'       => auth()->id(),
//            'media_id'      => $request->media_id,
//            'title'         => $title,
//            'slug'          => ShareService::makeSlug($title),
//            'min_read'      => ShareService::convertTextToReadMinute($body),
//            'body'          => $body,
//            'keywords'      => $request->keywords,
//            'description'   => $request->description,
//            'status'        => $request->status,
//        ]);
//    }
//
//    /**
//     * Update article by id & request.
//     *
//     * @param  $request
//     * @param  $id
//     * @return mixed
//     */
//    public function update($request, $id)
//    {
//        $title = $request->title;
//        $body = $request->body;
//
//        return $this->query()->whereId($id)->update([
//            'media_id' => $request->media_id,
//            'title' => $title,
//            'slug' => ShareService::makeSlug($title),
//            'min_read' => ShareService::convertTextToReadMinute($body),
//            'body' => $body,
//            'keywords' => $request->keywords,
//            'description' => $request->description,
//            'status' => $request->status,
//        ]);
//    }

    /**
     * Change status article by id.
     *
     * @param  $id
     * @param  string $status
     * @return int
     */
    public function changeStatus($id, string $status)
    {
        return $this->query()->where('id', $id)->update(['status' => $status]);
    }

    /**
     * Get query for article model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Post::query();
    }
}
