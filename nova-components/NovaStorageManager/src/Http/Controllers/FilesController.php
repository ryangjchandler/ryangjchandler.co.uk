<?php

namespace Ryangjchandler\NovaStorageManager\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FilesController
{
    public function __invoke(Request $request)
    {
        $basePath = $request->input('path', '/');

        $files = collect(array_merge(
            Storage::allDirectories("public{$basePath}"),
            Storage::allFiles("public{$basePath}"),
        ))->filter(function ($path) use ($basePath) {
            return count(array_filter(explode('/', Str::after($path, $basePath)))) <= 1;
        })->map(function ($path) use ($basePath) {
            $fullPath = storage_path("app/{$path}");

            return [
                'name' => trim(Str::after($path, $basePath), '/'),
                'type' => filetype($fullPath),
                'lastModified' => Carbon::parse(filemtime($fullPath))->format('d/m/Y H:i:s'),
                'permissions' => fileperms($fullPath),
            ];
        });

        return response()->json($files->toArray());
    }
}
