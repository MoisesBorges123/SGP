<?php

namespace App\Models\Painel\Estacionamento\Fluxo;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    //
    protected $table = 'parking';
    public $fillable=[
        'payment',
        'time',
        'vehicle'
    ];
}
