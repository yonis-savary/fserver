<?php

namespace App\Controllers;

use App\Controllers\Requests\DownloadRequest;
use App\Controllers\Requests\ShowDirectoryRequest;
use App\Models\Directory;
use Cube\Data\Bunch;
use Cube\Utils\Path;
use Cube\Web\Http\FileMIMETypes;
use Cube\Web\Http\Request;
use Cube\Web\Http\Response;

class DownloadController
{
    protected static function authorizeDirectory(Request $request, Directory $directory): ?Response {
        if ($directory->password_hash) {
            $password = $request->validated('password');
            if (!$password || !password_verify($password, $directory->password_hash)) {
                return Response::unauthorized('Invalid password');
            }
        }
        return null;
    }

    public static function showDirectory(ShowDirectoryRequest $request, Directory $directory) {
        $storage = $directory->toStorage();
        return self::authorizeDirectory($request, $directory)
            ?? Response::json(
                Bunch::of($storage->files())
                ->map(fn($file) => [
                    'file' => Path::toRelative($file, $storage->getRoot()),
                    'size' => filesize($file)
                ] )
                ->toArray()
            );
    }

    public static function download(DownloadRequest $request, Directory $directory) {
        if ($error = self::authorizeDirectory($request, $directory))
            return $error;

        $file = $request->validated('file');
        if (str_contains($file, '..') || str_contains($file, '/')) {
            return Response::unprocessableContent("Invalid file name");
        }

        $storage = $directory->toStorage();
        if (!$storage->isFile($file)) {
            return Response::unprocessableContent("Invalid file name");
        }

        $path = $storage->path($file);

        set_time_limit(0);
        header('Content-Type:'. FileMIMETypes::getFileMIMEType($path));
        header('Content-Disposition: attachment; filename='. basename($path));
        header('Content-Length: '. filesize($path));
        $fp = fopen($path, 'rb');

        while (!feof($fp)) {
            echo fread($fp, 8192);
            flush();
        }

        fclose($fp);
        exit;
    }
}