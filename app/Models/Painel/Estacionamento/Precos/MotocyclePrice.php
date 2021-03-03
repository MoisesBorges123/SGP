<?php

namespace App\Models\Painel\Estacionamento\Precos;

use Illuminate\Database\Eloquent\Model;

class MotocyclePrice extends Model
{
    //
    protected $table = 'price_motocycles';
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
