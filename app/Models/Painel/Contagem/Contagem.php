<?php

namespace App\Models\Painel\Contagem;

use Illuminate\Database\Eloquent\Model;

class Contagem extends Model
{
    //
    protected $table='contagem';
    public $fillable =[
        'coin',
        'banknote',
        'categor',
        'referer',
        'ip_device',
    ];
}
