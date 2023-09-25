<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);



        $itemList = Permission::create(['name' => 'itemList']);
        $itemCreate = Permission::create(['name' => 'itemCreate']);
        $itemEdit = Permission::create(['name' => 'itemEdit']);
        $itemDelete = Permission::create(['name' => 'itemDelete']);
        $itemShow = Permission::create(['name' => 'itemShow']);
        $deleteItemImage = Permission::create(['name' => 'deleteItemImage']);
        $getItemByCategory = Permission::create(['name' => 'getItemByCategory']);

        $storeSubscribe=Permission::create(['name' => 'storeSubscribe']);
        $payment=Permission::create(['name' => 'payment']);





        $userList=Permission::create(['name' => 'userList']);
        $userShow=Permission::create(['name' => 'userShow']);
        $userUpdate=Permission::create(['name' => 'userUpdate']);
        $userDestroy=Permission::create(['name' => 'userDestroy']);
        $userStatus=Permission::create(['name' => 'userStatus']);

        $admin->givePermissionTo([


            $itemList,
            $itemCreate,
            $itemEdit,
            $itemDelete,
            $itemShow,
            $deleteItemImage,
            $getItemByCategory,
            $storeSubscribe,
            $payment,


            $userList,
            $userShow,
            $userUpdate,
            $userDestroy,
            $userStatus

        ]);


        $user->givePermissionTo([


            $itemList,

            $itemShow,

            $getItemByCategory,
            $storeSubscribe,
            $payment
        ]);
    }
}
