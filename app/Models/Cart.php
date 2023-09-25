<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_subscribe_id',
        'quantity',
        'buy_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function userSubscribe()
    {
        return $this->belongsTo(UserSubscribe::class, 'user_subscribe_id');
    }

    public function carts()
{
    return $this->hasMany(Cart::class, 'user_subscribe_id');
}





}
