<?php

namespace App\Helpers;

use Carbon\Carbon;

class FileHelper
{
    private static function getPath(string $folderName): string
    {
        return 'public/' . $folderName . '/';
    }

    public static function uploadFile($file, $folderName = null, $filePrefix = null): string
    {
        $defaultFileName = Carbon::now()->timestamp . '-' . $file->getClientOriginalName();
        $fileName = $filePrefix ? $filePrefix . '.' . $file->getClientOriginalExtension() : $defaultFileName;
        $file->storeAs(self::getPath($folderName), $fileName);
        return $fileName;
    }

    public static function downloadFile(string $fileName, string $folderName): bool|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filePath = self::getPath($folderName) . $fileName;

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return false;
    }

    public static function deleteFile($folderName, $fileName): bool
    {
        $filePath = self::getPath($folderName) . $fileName;

        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        return true;
    }
}
