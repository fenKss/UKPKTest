<?php


namespace App\lib;


use App\lib\FS\Exceptions\FileNotExistException;

class FS
{
    /**
     * @param IFile $file
     *
     * @throws FileNotExistException
     */
    public static function rm(IFile $file)
    {
        if (FS::isFileExist($file)) {
            throw new FileNotExistException();
        }


    }

    public static function isDir(string $path): bool
    {
        return is_dir($path);
    }

    public static function rmdir(string $path): bool
    {
        try {
            return rmdir($path);
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function isFileExist(IFile $file): bool
    {
        return file_exists($file->getFullPath());
    }

}