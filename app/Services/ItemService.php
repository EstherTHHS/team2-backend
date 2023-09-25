<?php

namespace App\Services;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// use App\Interfaces\TicketAttachmentRepositoryInterface;

class ItemService
{
    protected $ItemRepoInterface;

    public function __construct(ItemRepositoryInterface $ItemRepoInterface)
    {
        $this->ItemRepoInterface = $ItemRepoInterface;
    }

    public function getItems()
    {
        return $this->ItemRepoInterface->getItems();
    }

    public function getItemById($id)
    {
        return $this->ItemRepoInterface->getItemById($id);
    }



    public function getItemByCategory($category)
    {
        return $this->ItemRepoInterface->getItemByCategory($category);
    }



    public function storeItem($validatedData)
    {
        $image= $validatedData['image_url'];
        $image_url = time() . "_" .  $image->getClientOriginalName();
        $image->storeAs('image/' .  $image_url );
        $data=Item::create([
            'name'=>$validatedData['name'],
            'description'=>$validatedData['description'],
            'price'=>$validatedData['price'],
            'category'=>$validatedData['category'],
            'stock'=>$validatedData['stock'],
            'image_url'=>$image_url,
        ]);

        return $data;
    }


    public function updateItem($validatedData,$id)
    {
        $item = Item::findOrFail($id);
        $item->name = $validatedData['name'];
        $item->description = $validatedData['description'];
        $item->price = $validatedData['price'];
        $item->category = $validatedData['category'];
        $item->stock = $validatedData['stock'];
            if ($validatedData->hasFile('image_url')) {
                $image = $validatedData['image_url'];
                $image_url = time() . "_" . $image->getClientOriginalName();
                $image->storeAs('image/', $image_url);
                $item->image_url = $image_url;
            }

            $item->save();

    }

    public function deleteItemImage($id,Request $request){
        $startTime = microtime(true);
        $item = Item::findOrFail($id);

        if (!$item) {
            return response()->error(request(), null, 'Item not found', 404, $startTime);
        }

        if ($item->image_url) {

            Storage::delete('itemImages/' . $item->image_url);
            $item->image_url = null;
            $item->save();
        }


        return response()->success($request, $item, 'Item Image Delete Successfully.', 200, $startTime, 1);
    }


    public function destory($id,Request $request){
        $startTime = microtime(true);
        $item = Item::findOrFail($id);

        if (!$item) {
            return response()->error(request(), null, 'Item not found', 404, $startTime);
        }

        $item->delete();


        return response()->success($request, $item, 'Item Delete Successfully.', 200, $startTime, 1);
    }



}
