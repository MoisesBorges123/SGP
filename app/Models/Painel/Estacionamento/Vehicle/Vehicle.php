<?php

namespace App\Models\Painel\Estacionamento\Vehicle;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    protected $table = 'vehicle';
    public $fillable =['placa','modelo','cor','pessoa','descricao','insencao','typevehicle'];

    public function person_info(){
        return $this->belongsTo(Pessoa::class,'pessoa','id');
    }
}
