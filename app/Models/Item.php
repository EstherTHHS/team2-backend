<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'stock',
        'image_url',
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function subscribers()
    {
        return $this->hasMany(UserSubscribe::class, 'item_id');
    }





}
