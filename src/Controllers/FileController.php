<?php

namespace Alireza\LaravelFileExplorer\Controllers;

use Alireza\LaravelFileExplorer\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FileController extends Controller
{
    public function renameFile(string $diskName, string $fileName, Request $request, FileService $fileService): JsonResponse
    {
        $validatedData = $request->validate([
            "oldPath" => "required|string",
            "newPath" => "required|string",
        ]);

        $result = $fileService->rename($diskName, $validatedData);

        return response()->json($result);
    }

    public function deleteFile(string $diskName, string $fileName, Request $request, FileService $fileService): JsonResponse
    {
        $validatedData = $request->validate([
            "path" => "required|string",
        ]);

        $result = $fileService->delete($diskName, $validatedData);

        return response()->json($result);
    }
}
