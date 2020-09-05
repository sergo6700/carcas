<?php

namespace Uploader;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class Uploader
 * @package Uploader
 */
class Uploader
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var string
     */
    protected $storageDisk;

    /**
     * @var string
     */
    protected $storagePath;

    /**
     * BaseUploader constructor.
     */
    public function __construct()
    {
        $this->storageDisk = config('uploader.disk');
        $this->storagePath = config('uploader.default_path');
    }

    /**
     * @param $name
     */
    public function setFileName($name)
    {
        $this->fileName = $name;
    }

    /**
     * @param $path
     */
    public function setStoragePath($path)
    {
        $this->storagePath = $path;
    }

    /**
     * @param UploadedFile $file
     * @return array
     * @throws \Exception
     */
    public function upload(UploadedFile $file)
    {
        $this->file = $file;
        $this->fileName = $this->generateFileName();

        return $this->fileUploadedResponse($this->store());
    }

    /**
     * @return false|string
     * @throws \Exception
     */
    protected function store()
    {
        $options = [
            'disk' => $this->storageDisk
        ];

        $result = $this->file->storeAs(
            $this->storagePath,
            $this->fileName,
            $options
        );

        if (!$result) {
            throw new \Exception('Failed to upload file');
        }

        return $result;
    }

    /**
     * @return string
     */
    protected function generateFileName()
    {
        $extension = $this->file->getClientOriginalExtension();

        return md5(Str::random(20)) . '.' . $extension;
    }

    /**
     * @param $filePath
     * @return array
     */
    protected function fileUploadedResponse($filePath)
    {
        $root = config("filesystems.disks.$this->storageDisk.root");

        $fullPath = $root . DIRECTORY_SEPARATOR . $filePath;

        return [
            'path' => $fullPath,
            'name' => $this->fileName,
            'storagePath' => $this->storagePath,
            'mimeType' => $this->file->getMimeType(),
            'size'      => $this->file->getSize(),
            'originalName' => $this->file->getClientOriginalName(),
            'url' => Storage::disk($this->storageDisk)->url($filePath)
        ];
    }
}
