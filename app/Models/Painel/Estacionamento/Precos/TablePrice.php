<?php

namespace App\Models\Painel\Estacionamento\Precos;

use Illuminate\Database\Eloquent\Model;

class TablePrice extends Model
{
    //
    protected $table = 'table_price';
    public $fillable = ['motocycle_price','car_price'];
    public $timestamps = true;
}
