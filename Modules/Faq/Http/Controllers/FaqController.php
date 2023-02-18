<?php

namespace Modules\Faq\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Http\Requests\FaqRequest;
use Modules\Faq\Repositories\FaqRepoEloquentInterface;
use Modules\Faq\Services\FaqService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class FaqController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'faq.index';

    /**
     * @var string
     */
    private string $class = Faq::class;

    public FaqRepoEloquentInterface $repo;
    public FaqService $service;

    /**
     * @param FaqRepoEloquentInterface $faqRepoEloquent
     * @param FaqService $faqService
     */
    public function __construct(FaqRepoEloquentInterface $faqRepoEloquent, FaqService $faqService)
    {
        $this->repo = $faqRepoEloquent;
        $this->service = $faqService;

        $this->middleware('can:'. Permission::PERMISSION_FAQS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_FAQ_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_FAQ_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_FAQ_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_FAQ_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $faqs = $this->repo->search(request()->search)->paginate(10);
            if (count($faqs) > 0) {
                $this->showToastOfFetchedRecordsCount(count($faqs));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $faqs = $this->repo->index()->paginate(10);
        }

        return view('Faq::index', compact(['faqs']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Faq::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FaqRequest $request
     * @return RedirectResponse
     */
    public function store(FaqRequest $request): RedirectResponse
    {

        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('پرسش  جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faq $faq
     * @return Application|Factory|View
     */
    public function edit(Faq $faq): View|Factory|Application
    {
        return view('Faq::edit', compact(['faq']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqRequest $request
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $this->service->update($request, $faq);
        return $this->showMessageWithRedirectRoute('پرسش شما با موفقیت ویرایش شد');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $result = $faq->delete();
        return $this->showMessageWithRedirectRoute('پرسش  شما با موفقیت حذف شد');
    }


    /**
     * @param Faq $faq
     * @return JsonResponse
     */
    public function status(Faq $faq): JsonResponse
    {
        return ShareService::changeStatus($faq);
    }

    /**
     * @param Faq $faq
     * @param TagRepositoryEloquentInterface $tagRepositoryEloquent
     * @return Application|Factory|View
     */
    public function tagsForm(Faq $faq, TagRepositoryEloquentInterface $tagRepositoryEloquent): View|Factory|Application
    {
        $tags = $tagRepositoryEloquent->index()->get();
        return view('Faq::tags-form', compact(['faq', 'tags']));
    }

    /**
     * @param FaqRequest $request
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function setTags(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->tags()->sync($request->tags);
        return $this->showMessageWithRedirectRoute('تگ های سوال با موفقیت بروزرسانی شد');
    }
}
