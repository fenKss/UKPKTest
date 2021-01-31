<?php

namespace App\lib\FS;

use App\lib\FS\Exceptions\DirectoryIsNotEmptyException;
use App\lib\FS\Exceptions\FileExistsException;
use App\lib\FS\Exceptions\FileNotExistException;
use App\lib\IFile;

class FS
{
    /**
     * @param string $path
     *
     * @return bool
     * @throws FileNotExistException
     */
    public static function rm(string $path): bool
    {
        if (!FS::isFileExist($path)) {
            throw new FileNotExistException();
        }
        return unlink($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isDir(string $path): bool
    {
        return is_dir($path);
    }

    /**
     * @param string $dir
     * @param bool   $force
     *
     * @return bool
     * @throws DirectoryIsNotEmptyException
     */
    public static function rmdir(string $dir, bool $force = false): bool
    {
        if (!self::isDir($dir)){
            return false;
        }
        $files = array_diff(scandir($dir), array('.','..'));
        if (!empty($files) && !$force){
            throw new DirectoryIsNotEmptyException();
        }
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? static::rmdir("$dir/$file") : unlink("$dir/$file");
        }
        return true;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isFileExist(string $path): bool
    {
        return file_exists(realpath($path));
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public static function generateRandomString(int $length): string {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    /**
     * @param string $dir
     */
    public static function mkdir(string $dir) {
        if ( !file_exists( $dir ) && !is_dir( $dir ) ) {
            mkdir($dir, 0777, true);
        }
    }

}