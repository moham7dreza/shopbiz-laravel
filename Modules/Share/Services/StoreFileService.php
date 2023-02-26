<?php

namespace Modules\Share\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Share\Entities\File;
use Modules\Share\Services\File\FileService;

class StoreFileService
{
    public FileService $fileService;

    /**
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param $request
     * @param $model
     * @return Builder|Model|string
     */
    public function store($request, $model): Model|Builder|string
    {
        if ($request->hasFile('file')) {
            [$result, $fileSize, $fileFormat] = ShareService::saveFileAndMove('files',
                $request->file('file'), $this->fileService);
            if (!$result) {
                return 'upload failed';
            }
        } else {
            [$result, $fileSize, $fileFormat] = null;
        }
        return $this->query()->create([
            'user_id' => auth()->id() ?? null,
            'file_path' => $result,
            'file_size' => $fileSize,
            'file_type' => $fileFormat,
            'status' => File::STATUS_INACTIVE,
            'fileable_id' => $model->id,
            'fileable_type' => get_class($model),
        ]);
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return File::query();
    }
}
