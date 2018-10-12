<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $casts = ['id' => 'string'];
    public $incrementing = false;
    public $timestamps = false;
}
