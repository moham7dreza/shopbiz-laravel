<?php

namespace Modules\Notify\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Notify\Entities\Email;
use Modules\Notify\Entities\EmailFile;
use Modules\Notify\Http\Requests\EmailFileRequest;
use Modules\Notify\Repositories\EmailFile\EmailFileRepoEloquentInterface;
use Modules\Notify\Services\EmailFile\EmailFileService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\File\FileService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class EmailFileController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'email-file.index';

    /**
     * @var string
     */
    private string $class = EmailFile::class;

    public EmailFileRepoEloquentInterface $repo;
    public EmailFileService $service;

    /**
     * @param EmailFileRepoEloquentInterface $emailFileRepoEloquent
     * @param EmailFileService $emailFileService
     */
    public function __construct(EmailFileRepoEloquentInterface $emailFileRepoEloquent, EmailFileService $emailFileService)
    {
        $this->repo = $emailFileRepoEloquent;
        $this->service = $emailFileService;

        $this->middleware('can:'. Permission::PERMISSION_EMAIL_NOTIFY_FILES)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_EMAIL_NOTIFY_FILE_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_EMAIL_NOTIFY_FILE_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_EMAIL_NOTIFY_FILE_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_EMAIL_NOTIFY_FILE_STATUS)->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Email $email
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Email $email): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $files = $this->repo->search(request()->search)->paginate(10);
            if (count($files) > 0) {
                $this->showToastOfFetchedRecordsCount(count($files));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $files = $this->repo->sort(request()->sort, request()->dir, $email->id)->paginate(10);
            if (count($files) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            $this->showToastOfNotDataExists();
        } else {
            $files = $email->files()->paginate(10);
        }

        return view('Notify::email-file.index', compact(['email', 'files']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Email $email
     * @return Application|Factory|View
     */
    public function create(Email $email): View|Factory|Application
    {
        return view('Notify::email-file.create', compact(['email']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmailFileRequest $request
     * @param Email $email
     * @return RedirectResponse
     */
    public function store(EmailFileRequest $request, Email $email): RedirectResponse
    {

        $this->service->store($request, $email->id);
        return $this->showMessageWithRedirectRoute('فایل جدید شما با موفقیت ثبت شد', params: [$email]);
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
     * @param EmailFile $file
     * @return Application|Factory|View
     */
    public function edit(EmailFile $file): View|Factory|Application
    {
        return view('Notify::email-file.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmailFileRequest $request
     * @param EmailFile $file
     * @return RedirectResponse
     */
    public function update(EmailFileRequest $request, EmailFile $file): RedirectResponse
    {
        $emailId = $file->email->id;
        $this->service->update($request, $emailId, $file);
        return $this->showMessageWithRedirectRoute('فایل شما با موفقیت ویرایش شد', params: [$emailId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EmailFile $file
     * @return RedirectResponse
     */
    public function destroy(EmailFile $file): RedirectResponse
    {
        $result = $file->delete();
        return $this->showMessageWithRedirectRoute('فایل شما با موفقیت حذف شد', params: [$file->email->id]);
    }

    /**
     * @param EmailFile $file
     * @return JsonResponse
     */
    public function status(EmailFile $file): JsonResponse
    {
        return ShareService::changeStatus($file);
    }
}
