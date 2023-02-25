<?php

namespace Modules\Ticket\Services\TicketFile;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Share\Services\File\FileService;
use Modules\Share\Services\ShareService;
use Modules\Ticket\Entities\TicketFile;

class TicketFileService implements TicketFileServiceInterface
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
     * @return Builder|Model|string
     */
    public function store($request): Model|Builder|string
    {
        if ($request->hasFile('file')) {
            [$result, $fileSize, $fileFormat] = ShareService::saveFileAndMove('ticket-files',
                $request->file('file'), $this->fileService);
            if (!$result) {
                return 'upload failed';
            }
        } else {
            [$result, $fileSize, $fileFormat] = null;
        }
        return $this->query()->create([
            'user_id' => auth()->id(),
            'file_path' => $result,
            'file_size' => $fileSize,
            'file_type' => $fileFormat,
            'status' => $request->status,
            'ticket_id' => $request->ticket_id,
        ]);
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return TicketFile::query();
    }
}
