<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subscribe_user_id',
        'amount',
        'payment_date',
        'payment_method'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function userSubscribe()
    {
        return $this->belongsTo(UserSubscribe::class, 'subscribe_user_id', 'user_id');
    }
}
