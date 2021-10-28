<?php

namespace App\Models\Painel\Estacionamento\Payment;

use App\Models\Painel\Estacionamento\Fluxo\Parking;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payments';
    public $fillable = [
        'value',
        'discount',
        'justify_discount',
        'table_price',
        'payed',
        'modality',
        'date_payed'
    ];
    public function park(){
        return $this->hasOne(Parking::class,'payment','id');
    }
    public $timestamps=true;

}
