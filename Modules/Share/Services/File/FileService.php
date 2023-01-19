<?php

namespace Modules\Share\Services\File;

class FileService extends FileToolsService
{
    /**
     * @param $file
     * @return false|string
     */
    public function moveToPublic($file): false|string
    {
        //set File
        $this->setFile($file);
        //execute provider
        $this->provider();
        //save File
        $result = $file->move(public_path($this->getFinalFileDirectory()), $this->getFinalFileName());
        return $result ? $this->getFileAddress() : false;
    }

    /**
     * @param $file
     * @return false|string
     */
    public function moveToStorage($file): false|string
    {
        //set File
        $this->setFile($file);
        //execute provider
        $this->provider();
        //save File
        $result = $file->move(storage_path($this->getFinalFileDirectory()), $this->getFinalFileName());
        return $result ? $this->getFileAddress() : false;
    }

    /**
     * @param $filePath
     * @return void
     */
    public function deleteFile($filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * @param $directory
     * @return bool
     */
    public function deleteDirectoryAndFiles($directory): bool
    {
        if (!is_dir($directory)) {
            return false;
        }
        $files = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDirectoryAndFiles($file);
            } else {
                unlink($file);
            }
        }
        return rmdir($directory);
    }
}
