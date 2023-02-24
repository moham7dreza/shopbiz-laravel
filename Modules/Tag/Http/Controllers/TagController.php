<?php

namespace Modules\Tag\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Share\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Http\Requests\TagRequest;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;
use Modules\Tag\Services\TagService;
use Spatie\Tags\Tag;

class TagController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $class = Tag::class;

    /**
     * @var string
     */
    private string $redirectRoute = 'tag.index';

    public TagRepositoryEloquentInterface $repo;
    public TagService $service;

    /**
     * @param TagRepositoryEloquentInterface $repo
     * @param TagService $service
     */
    public function __construct(TagRepositoryEloquentInterface $repo, TagService $service)
    {
//        $this->middleware('can:role-admin')->only(['index']);
        $this->repo = $repo;
        $this->service = $service;

        $this->middleware('can:' . Permission::PERMISSION_TAGS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_TAG_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_TAG_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_TAG_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_TAG_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $tags = $this->repo->search(request()->search)->paginate(10);
            if (count($tags) > 0) {
                $this->showToastOfFetchedRecordsCount(count($tags));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $tags = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($tags) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $tags = $this->repo->index()->paginate(5);
        }

        return view('Tag::index', compact(['tags']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Tag::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TagRequest $request
     * @return RedirectResponse
     */
    public function store(TagRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('تگ جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag $tag
     * @return Application|Factory|View
     */
    public function edit(Tag $tag): Application|Factory|View
    {
        return view('Tag::edit', compact(['tag']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
        $this->service->update($request, $tag);
        return $this->showMessageWithRedirectRoute('تگ شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $result = $tag->delete();
        return $this->showMessageWithRedirectRoute('تگ شما با موفقیت حذف شد');
    }


    /**
     * @param Tag $tag
     * @return JsonResponse
     */
    public function status(Tag $tag): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($tag);
    }
}
