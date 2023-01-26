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
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class EmailController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'email.index';

    /**
     * @var string
     */
    private string $class = Email::class;

    public EmailRepoEloquentInterface $repo;
    public EmailService $service;

    /**
     * @param EmailRepoEloquentInterface $emailRepoEloquent
     * @param EmailService $emailService
     */
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $emails = $this->repo->search(request()->search)->paginate(10);
            if (count($emails) > 0) {
                $this->showToastOfFetchedRecordsCount(count($emails));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $emails = $this->repo->index()->paginate(10);
        }

        return view('Notify::email.index', compact(['emails']));

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
        $this->service->store($request);
        return $this->showMessageWithRedirect('ایمیل شما با موفقیت ثبت شد');
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
        return view('Notify::email.edit', compact(['email']));
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
        $this->service->update($request, $email);
        return $this->showMessageWithRedirect('ایمیل شما با موفقیت ویرایش شد');
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
        return $this->showMessageWithRedirect('ایمیل شما با موفقیت حذف شد');
    }


    /**
     * @param Email $email
     * @return JsonResponse
     */
    public function status(Email $email): JsonResponse
    {
        return ShareService::changeStatus($email);
    }
}
