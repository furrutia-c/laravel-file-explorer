<?php

namespace Alireza\LaravelFileExplorer\Controllers;

use Alireza\LaravelFileExplorer\Requests\CreateFileRequest;
use Alireza\LaravelFileExplorer\Requests\DeleteItemRequest;
use Alireza\LaravelFileExplorer\Requests\DownloadFileRequest;
use Alireza\LaravelFileExplorer\Requests\PathRequest;
use Alireza\LaravelFileExplorer\Requests\RenameItemRequest;
use Alireza\LaravelFileExplorer\Requests\UpdateItemContentRequest;
use Illuminate\Http\Request;
use Alireza\LaravelFileExplorer\Requests\UploadItemsRequest;
use Alireza\LaravelFileExplorer\Services\ItemService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends Controller
{
    /**
     * Rename a file.
     *
     * @param string $diskName
     * @param string $fileName
     * @param RenameItemRequest $request
     * @param ItemService $itemService
     * @return JsonResponse
     */
    public function renameItem(string $diskName, string $fileName, RenameItemRequest $request, ItemService $itemService): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $itemService->rename($diskName, $fileName, $validatedData);

        return response()->json($result);
    }

    /**
     * Delete a file.
     *
     * @param string $diskName
     * @param DeleteItemRequest $request
     * @param ItemService $itemService
     * @return JsonResponse
     */
    public function deleteItems(string $diskName, DeleteItemRequest $request, ItemService $itemService): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $itemService->delete($diskName, $validatedData);

        return response()->json($result);
    }

    /**
     * Create a file.
     *
     * @param string $diskName
     * @param string $dirName
     * @param CreateFileRequest $request
     * @param ItemService $itemService
     * @return JsonResponse
     */
    public function createFile(string $diskName, string $dirName, CreateFileRequest $request, ItemService $itemService): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $itemService->create($diskName, $validatedData);

        return response()->json($result);
    }

    /**
     * Upload files.
     *
     * @param string $diskName
     * @param UploadItemsRequest $request
     * @param ItemService $itemService
     * @return JsonResponse
     */
    public function uploadItems(string $diskName, UploadItemsRequest $request, ItemService $itemService): JsonResponse
    {
        $validatedData = $request->validated();
        $result = $itemService->upload($diskName, $validatedData);

        return response()->json($result);
    }

    /**
     * Download item/items.
     *
     * @param string $diskName
     * @param DownloadFileRequest $request
     * @param ItemService $itemService
     * @return BinaryFileResponse|JsonResponse|StreamedResponse
     * @throws Exception
     */
    public function downloadItems(string $diskName, DownloadFileRequest $request, ItemService $itemService): BinaryFileResponse|JsonResponse|StreamedResponse
    {
        return $itemService->download($diskName, $request->validated());
    }

    /**
     * Get File content for editor
     *
     * @param string $diskName
     * @param string $itemName
     * @param PathRequest $pathRequest
     * @param ItemService $itemService
     * @return JsonResponse
     */
    public function getContent(string $diskName, string $itemName, PathRequest $pathRequest, ItemService $itemService): JsonResponse
    {
        return response()->json([
            "result" => [
                "content" => $itemService->getItemContent($diskName, $pathRequest->validated()),
            ]
        ]);
    }

    public function updateContent(string $diskName, string $itemName, UpdateItemContentRequest $updateItemContentRequest, ItemService $itemService): JsonResponse
    {
        $result = $itemService->updateItemContent($diskName, $updateItemContentRequest->validated());
        return response()->json($result);
    }
}
