<?php

namespace App\Models\Painel\Estacionamento\Fluxo;

use App\Models\Painel\Estacionamento\Payment\Payment;
use App\Models\Painel\Estacionamento\Time\TimeParking;
use App\Models\Painel\Estacionamento\Vehicle\Vehicle;
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

    public function payment_info(){
        return $this->belongsTo(Payment::class);
    }
    public function time_info(){
        return $this->belongsTo(TimeParking::class);
    }
    public function vehicle_info(){
        return $this->belongsTo(Vehicle::class);
    }
}
