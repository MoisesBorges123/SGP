<?php

namespace App\Models\Painel\Estacionamento\Precos;

use Illuminate\Database\Eloquent\Model;

class CarPrice extends Model
{
    //
    protected $table = 'price_cars';
    public $timestamps = true;
    public $fillable = [
        'min_60',
        'min_30',
        'min_15',
        'diaria',
        'pernoite',
        'mensalidade'
    ];
}
