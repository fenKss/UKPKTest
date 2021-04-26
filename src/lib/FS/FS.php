<?php

namespace App\lib\FS;

use App\lib\FS\Exceptions\DirectoryIsNotEmptyException;
use App\lib\FS\Exceptions\FileNotExistException;

class FS
{
    /**
     * @throws FileNotExistException
     */
    public static function rm(string $path): bool
    {
        if (!FS::isFileExist($path)) {
            throw new FileNotExistException();
        }
        return unlink($path);
    }

    public static function isDir(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * @throws DirectoryIsNotEmptyException
     */
    public static function rmdir(string $dir, bool $force = false): bool
    {
        if (!self::isDir($dir)) {
            return false;
        }
        $files = array_diff(scandir($dir), array('.', '..'));
        if (!empty($files) && !$force) {
            throw new DirectoryIsNotEmptyException();
        }
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? static::rmdir("$dir/$file")
                : unlink("$dir/$file");
        }
        return true;
    }

    public static function isFileExist(string $path): bool
    {
        return file_exists(realpath($path));
    }

    public static function generateRandomString(int $length): string
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        $key .= str_repeat($keys[array_rand($keys)], $length);

        return $key;
    }

    public static function mkdir(string $dir)
    {
        if (!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
    }
}