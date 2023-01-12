<?php

namespace Modules\Notify\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Notify\Entities\Email;
use Modules\Notify\Http\Requests\EmailRequest;
use Modules\Notify\Repositories\Email\EmailRepoEloquentInterface;
use Modules\Notify\Services\Email\EmailService;
use Modules\Share\Http\Controllers\Controller;

class EmailController extends Controller
{
    private string $redirectRoute = 'email.index';

    private string $class = Email::class;

    public EmailRepoEloquentInterface $repo;
    public EmailService $service;

    public function __construct(EmailRepoEloquentInterface $emailRepoEloquent, EmailService $emailService)
    {
        $this->repo = $emailRepoEloquent;
        $this->service = $emailService;

        $this->middleware('can:permission-email-notify')->only(['index']);
        $this->middleware('can:permission-email-notify-create')->only(['create', 'store']);
        $this->middleware('can:permission-email-notify-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-email-notify-delete')->only(['destroy']);
        $this->middleware('can:permission-email-notify-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $emails = Email::query()->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('Notify::email.index', compact('emails'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Notify::email.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmailRequest $request
     * @return RedirectResponse
     */
    public function store(EmailRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $email = Email::query()->create($inputs);
        return redirect()->route('email.index')->with('swal-success', 'ایمیل شما با موفقیت ثبت شد');
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
     * @param Email $email
     * @return Application|Factory|View
     */
    public function edit(Email $email): View|Factory|Application
    {
        return view('Notify::email.edit', compact('email'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmailRequest $request
     * @param Email $email
     * @return RedirectResponse
     */
    public function update(EmailRequest $request, Email $email): RedirectResponse
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $email->update($inputs);
        return redirect()->route('email.index')->with('swal-success', 'ایمیل شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Email $email
     * @return RedirectResponse
     */
    public function destroy(Email $email): RedirectResponse
    {
        $result = $email->delete();
        return redirect()->route('email.index')->with('swal-success', 'ایمیل شما با موفقیت حذف شد');
    }


    /**
     * @param Email $email
     * @return JsonResponse
     */
    public function status(Email $email): JsonResponse
    {

        $email->status = $email->status == 0 ? 1 : 0;
        $result = $email->save();
        if ($result) {
            if ($email->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}
