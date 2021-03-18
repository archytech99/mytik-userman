<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    public $keyType = 'char';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hosts', 'username', 'password', 'port'
    ];
}
