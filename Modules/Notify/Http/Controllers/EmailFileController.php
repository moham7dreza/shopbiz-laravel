<?php

namespace Modules\Notify\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Notify\Entities\Email;
use Modules\Notify\Entities\EmailFile;
use Modules\Notify\Http\Requests\EmailFileRequest;
use Modules\Notify\Repositories\EmailFile\EmailFileRepoEloquentInterface;
use Modules\Notify\Services\EmailFile\EmailFileService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\File\FileService;

class EmailFileController extends Controller
{
    private string $redirectRoute = 'email-file.index';

    private string $class = EmailFile::class;

    public EmailFileRepoEloquentInterface $repo;
    public EmailFileService $service;

    public function __construct(EmailFileRepoEloquentInterface $emailFileRepoEloquent, EmailFileService $emailFileService)
    {
        $this->repo = $emailFileRepoEloquent;
        $this->service = $emailFileService;

        $this->middleware('can:permission-email-notify-files')->only(['index']);
        $this->middleware('can:permission-email-notify-file-create')->only(['create', 'store']);
        $this->middleware('can:permission-email-notify-file-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-email-notify-file-delete')->only(['destroy']);
        $this->middleware('can:permission-email-notify-file-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Email $email
     * @return Application|Factory|View
     */
    public function index(Email $email): View|Factory|Application
    {
        $files = $email->files()->paginate(10);
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
        return view('Notify::email-file.create', compact('email'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmailFileRequest $request
     * @param Email $email
     * @param FileService $fileService
     * @return RedirectResponse
     */
    public function store(EmailFileRequest $request, Email $email, FileService $fileService): RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('file')) {
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            $result = $fileService->moveToPublic($request->file('file'));
            // $result = $fileService->moveToStorage($request->file('file'));
            $fileFormat = $fileService->getFileFormat();
            if ($result === false) {
                return redirect()->route('email-file.index', $email->id)->with('swal-error', 'آپلود فایل با خطا مواجه شد');
            }
        }

        $inputs['public_mail_id'] = $email->id;
        $inputs['file_path'] = $result;
        $inputs['file_size'] = $fileSize;
        $inputs['file_type'] = $fileFormat;
        $file = EmailFile::query()->create($inputs);
        return redirect()->route('email-file.index', $email->id)->with('swal-success', 'فایل جدید شما با موفقیت ثبت شد');
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
     * @param FileService $fileService
     * @return RedirectResponse
     */
    public function update(EmailFileRequest $request, EmailFile $file, FileService $fileService): RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('file')) {
            if (!empty($file->file_path)) {
                // $fileService->deleteFile($file->file_path, true);
                $fileService->deleteFile($file->file_path);
            }
            $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'email-files');
            $fileService->setFileSize($request->file('file'));
            $fileSize = $fileService->getFileSize();
            $result = $fileService->moveToPublic($request->file('file'));
            // $result = $fileService->moveToStorage($request->file('file'));
            $fileFormat = $fileService->getFileFormat();
            if ($result === false) {
                return redirect()->route('email-file.index', $file->email->id)->with('swal-error', 'آپلود فایل با خطا مواجه شد');
            }
            $inputs['file_path'] = $result;
            $inputs['file_size'] = $fileSize;
            $inputs['file_type'] = $fileFormat;
        }
        $file->update($inputs);
        return redirect()->route('email-file.index', $file->email->id)->with('swal-success', 'فایل  شما با موفقیت ویرایش شد');
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
        return redirect()->route('email-file.index', $file->email->id)->with('swal-success', 'فایل شما با موفقیت حذف شد');
    }

    /**
     * @param EmailFile $file
     * @return JsonResponse
     */
    public function status(EmailFile $file): JsonResponse
    {

        $file->status = $file->status == 0 ? 1 : 0;
        $result = $file->save();
        if ($result) {
            if ($file->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
