<?php

namespace Modules\Faq\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Http\Requests\FaqRequest;
use Modules\Faq\Repositories\FaqRepoEloquentInterface;
use Modules\Faq\Services\FaqService;
use Modules\Share\Http\Controllers\Controller;

class FaqController extends Controller
{
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

        $this->middleware('can:permission-faqs')->only(['index']);
        $this->middleware('can:permission-faq-create')->only(['create', 'store']);
        $this->middleware('can:permission-faq-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-faq-delete')->only(['destroy']);
        $this->middleware('can:permission-faq-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $faqs = $this->repo->index()->paginate(10);
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
        $inputs = $request->all();
        $faq = Faq::query()->create($inputs);
        return redirect()->route('faq.index')->with('swal-success', 'پرسش  جدید شما با موفقیت ثبت شد');
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
        $inputs = $request->all();
        $faq->update($inputs);
        return redirect()->route('faq.index')->with('swal-success', 'پرسش شما با موفقیت ویرایش شد');;
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
        return redirect()->route('faq.index')->with('swal-success', 'پرسش  شما با موفقیت حذف شد');
    }


    /**
     * @param Faq $faq
     * @return JsonResponse
     */
    public function status(Faq $faq): JsonResponse
    {
        $faq->status = $faq->status == 0 ? 1 : 0;
        $result = $faq->save();
        if ($result) {
            if ($faq->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
