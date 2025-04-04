<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = ['amount', 'order_id', 'timestamp', 'status', 'user_fullname'];
}
