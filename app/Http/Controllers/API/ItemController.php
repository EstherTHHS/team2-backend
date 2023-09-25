<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{

    protected ItemService $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService =$itemService;
        // $this->middleware('permission:itemList', ['only' => 'index']);
        // $this->middleware('permission:itemCreate', ['only' => ['store']]);
        // $this->middleware('permission:itemEdit', ['only' => ['update']]);
        // $this->middleware('permission:itemDelete', ['only' => 'destroy']);
        // $this->middleware('permission:itemShow', ['only' => 'show']);
        // $this->middleware('permission:deleteItemImage', ['only' => 'deleteItemImage']);
        // $this->middleware('permission:getItemByCategory', ['only' => 'getItemByCategory']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $startTime = microtime(true);
            $data = $this->itemService->getItems();

            return response()->success($request, $data, 'Item List Successfully.', 200, $startTime, count($data));
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item Store Error" . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        try {

            $startTime = microtime(true);

            $validatedData = $request->validated();

            $data = $this->itemService->storeItem($validatedData);

            return response()->success($request, $data, 'Item Create Successfully.', 201, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item Store Error" . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id,Request $request)
    {
        try {
            $startTime = microtime(true);

            $data = $this->itemService->getItemById($id);

            if ($data) {
                return response()->success($request, $data, 'Item Show Successfully.', 200, $startTime, count($data['relatedItems']));
            } else {
                return response()->error($request, null, 'Item not found', 404, $startTime);
            }
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item Show Error: " . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }




    public function getItemByCategory(Request $request,$categroy)
    {
        try {

            $startTime = microtime(true);

            $data = $this->itemService->getItemByCategory($categroy);

            return response()->success($request, $data, 'Item Category list Successfully.', 200, $startTime, count($data));
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item Show Error" . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, int $id)
    {
        try {

            $startTime = microtime(true);

            $validatedData = $request->validated();

            $data = $this->itemService->updateItem($validatedData,$id);

            return response()->success($request, $data, 'Item Update Successfully.', 201, $startTime, 1);
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item Store Error" . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,Request $request)
    {
        try {

            $startTime = microtime(true);
            $data = $this->itemService->destory($id,$request);

            return $data;
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item destory Error" . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }


    public function deleteItemImage(int $id,Request $request)
    {

        try {

            $startTime = microtime(true);
            $data = $this->itemService->deleteItemImage($id,$request);

            return $data;
        } catch (Exception $e) {
            Log::channel('sora_error_log')->error("Item Image Delete Error" . $e->getMessage());
            return response()->error($request, null, $e->getMessage(), 500, $startTime);
        }
    }
}
