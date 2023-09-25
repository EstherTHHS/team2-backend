<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface
{

    public function getItems()
    {


        $items= Item::all();
        $items->each(function ($item) {
            $item->image_url = asset('image/' . $item->image_url);
        });

        return $items;
    }







    // public function getItemById($id)
    // {

    //     $items= Item::where('id',$id)->get();
    //     $items->each(function ($item) {
    //         $item->image_url = asset('image/' . $item->image_url);
    //     });
    //     return $items;

    // }
    public function getItemById($id)
{

    $item = Item::find($id);


    if (!$item) {

        return null;
    }


    $item->image_url = asset('image/' . $item->image_url);


    $category = $item->category;


    $relatedItems = Item::where('category', $category)
    ->inRandomOrder()
    ->take(4)
    ->get();


    $relatedItems->each(function ($relatedItem) {
        $relatedItem->image_url = asset('image/' . $relatedItem->image_url);
    });


    return [
        'item' => $item,
        'relatedItems' => $relatedItems,
    ];
}


    public function getItemByCategory($category)
    {

        $items = Item::where('category', $category)->get();

        $items->each(function ($item) {
            $item->image_url = asset('image/' . $item->image_url);
        });

        return $items;
    }
}
