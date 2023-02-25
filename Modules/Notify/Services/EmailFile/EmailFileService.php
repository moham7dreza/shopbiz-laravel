<?php

namespace Modules\Notify\Services\EmailFile;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Notify\Entities\EmailFile;
use Modules\Share\Services\File\FileService;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class EmailFileService implements EmailFileServiceInterface
{
    public FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param $request
     * @param $emailId
     * @return Builder|Model|string
     */
    public function store($request, $emailId): Model|Builder|string
    {
        if ($request->hasFile('file')) {
            [$result, $fileSize, $fileFormat] = ShareService::saveFileAndMove('email-files',
                $request->file('file'), $this->fileService);
            if (!$result) {
                return 'upload failed';
            }
        } else {
            [$result, $fileSize, $fileFormat] = null;
        }
        return $this->query()->create([
            'public_mail_id' => $emailId,
            'file_path' => $result,
            'file_size' => $fileSize,
            'file_type' => $fileFormat,
            'status' => $request->status,
        ]);
    }


    /**
     * @param $request
     * @param $emailId
     * @param $file
     * @return RedirectResponse|mixed
     */
    public function update($request, $emailId, $file): mixed
    {
        if ($request->hasFile('file')) {
            if (!empty($file->file_path)) {
                // $fileService->deleteFile($file->file_path, true);
                $this->fileService->deleteFile($file->file_path);
            }
            [$result, $fileSize, $fileFormat] = ShareService::saveFileAndMove('email-files',
                $request->file('file'), $this->fileService);
            if (!$result) {
                return $this->showMessageWithRedirectRoute(msg: 'آپلود فایل با خطا مواجه شد', status: 'swal-error'
                    ,params: [$emailId]);
            }
        } else {
            [$result, $fileSize, $fileFormat] = null;
        }
        return $file->update([
            'public_mail_id' => $emailId,
            'file_path' => $result,
            'file_size' => $fileSize,
            'file_type' => $fileFormat,
            'status' => $request->status,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return EmailFile::query();
    }
}
