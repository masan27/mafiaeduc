<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    private static function getPath(string $folderName): string
    {
        return $folderName;
    }

    public static function uploadFile($file, $folderName = null, $filePrefix = null): string
    {
        if (!$filePrefix) {
            $defaultFileName = Carbon::now()->timestamp . '-' . $file->getClientOriginalName();
            $fileName = $defaultFileName;
        } else {
            $fileName = $filePrefix . '.' . $file->getClientOriginalExtension();
        }

        return $file->storeAs(self::getPath($folderName), $fileName, ['disk' => 'public']);
    }

    public static function getDownloadFileUrl(string $filePath, string $filename)
    {
        if (!self::isFileExist($filePath)) {
            return false;
        }

        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        $filename = $filename . '.' . $fileExtension;

        return Storage::disk('public')->download($filePath, $filename);
    }

    public static function isFileExist($filePath): bool
    {
        return Storage::disk('public')->exists($filePath);
    }

    public static function getFileUrl(string|null $filePath): string
    {
        return url(Storage::url($filePath));
    }

    public static function deleteFile($filePath): bool
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        return true;
    }
}
