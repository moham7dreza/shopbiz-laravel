<?php

namespace Modules\Share\Services\File;

class FileToolsService
{
    protected $file;
    protected $exclusiveDirectory;
    protected $fileDirectory;
    protected $fileName;
    protected $fileFormat;
    protected $finalFileDirectory;
    protected $finalFileName;
    protected $fileSize;

    /**
     * @param $file
     * @return void
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getExclusiveDirectory(): mixed
    {
        return $this->exclusiveDirectory;
    }

    /**
     * @param $exclusiveDirectory
     * @return void
     */
    public function setExclusiveDirectory($exclusiveDirectory): void
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }

    /**
     * @return mixed
     */
    public function getFileDirectory(): mixed
    {
        return $this->fileDirectory;
    }

    /**
     * @param $fileDirectory
     * @return void
     */
    public function setFileDirectory($fileDirectory): void
    {
        $this->fileDirectory = trim($fileDirectory, '/\\');
    }

    /**
     * @return mixed
     */
    public function getFileSize(): mixed
    {
        return $this->fileSize;
    }

    /**
     * @param $file
     * @return void
     */
    public function setFileSize($file): void
    {
        $this->fileSize = $file->getSize();
    }

    /**
     * @return mixed
     */
    public function getFileName(): mixed
    {
        return $this->fileName;
    }

    /**
     * @param $fileName
     * @return void
     */
    public function setFileName($fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return false|null
     */
    public function setCurrentFileName(): ?false
    {
        return !empty($this->file) ? $this->setFileName(pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME)) : false;
        // $_FILES['file']['name']
    }

    /**
     * @return mixed
     */
    public function getFileFormat(): mixed
    {
        return $this->fileFormat;
    }

    /**
     * @param $fileFormat
     * @return void
     */
    public function setFileFormat($fileFormat): void
    {
        $this->fileFormat = $fileFormat;
    }

    /**
     * @return mixed
     */
    public function getFinalFileDirectory(): mixed
    {
        return $this->finalFileDirectory;
    }

    /**
     * @param $finalFileDirectory
     * @return void
     */
    public function setFinalFileDirectory($finalFileDirectory): void
    {
        $this->finalFileDirectory = $finalFileDirectory;
    }

    /**
     * @return mixed
     */
    public function getFinalFileName(): mixed
    {
        return $this->finalFileName;
    }

    /**
     * @param $finalFileName
     * @return void
     */
    public function setFinalFileName($finalFileName): void
    {
        $this->finalFileName = $finalFileName;
    }

    /**
     * @param $fileDirectory
     * @return void
     */
    protected function checkDirectory($fileDirectory): void
    {
        if (!file_exists($fileDirectory)) {
            mkdir($fileDirectory, 0755, true);
        }
    }

    /**
     * @return string
     */
    public function getFileAddress(): string
    {
        return $this->finalFileDirectory . DIRECTORY_SEPARATOR . $this->finalFileName;
    }

    /**
     * @return void
     */
    protected function provider(): void
    {
        //set properties
            $this->getFileDirectory() ?? $this->setFileDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
            $this->getFileName() ?? $this->setFileName(time());
        $this->setFileFormat(pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION));

        //set final File Directory
        $finalFileDirectory = empty($this->getExclusiveDirectory()) ? $this->getFileDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getFileDirectory();
        $this->setFinalFileDirectory($finalFileDirectory);

        //set final File name
        $this->setFinalFileName($this->getFileName() . '.' . $this->getFileFormat());

        //check adn create final File directory
        $this->checkDirectory($this->getFinalFileDirectory());
    }
}
