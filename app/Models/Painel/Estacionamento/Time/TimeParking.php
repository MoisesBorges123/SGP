<?php

namespace App\Models\Painel\Estacionamento\Time;

use Illuminate\Database\Eloquent\Model;

class TimeParking extends Model
{
    //
    protected $table ='timeparking';
    public $fillable = [
        'hour_in',
        'hour_out',
        'min_in',
        'min_out',
        'date_in',
        'date_out',
        'church_time',

    ];
    public $timestamps=true;
}
