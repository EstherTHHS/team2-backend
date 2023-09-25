<?php

namespace App\Interfaces;



interface ItemRepositoryInterface
{
    public function getItems();
    public function getItemById($id);
    public function getItemByCategory($category);

}
