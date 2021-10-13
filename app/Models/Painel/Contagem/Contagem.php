<?php

namespace App\Models\Painel\Contagem;

use Illuminate\Database\Eloquent\Model;
use App\Models\Painel\Contagem\Banknote;
use App\Models\Painel\Contagem\Coin;
use App\Models\Painel\Contagem\Categor;
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
    public function coins(){
        return $this->belongsTo(Coin::class,'coin');
    }
    public function banknotes(){
        return $this->belongsTo(Banknote::class,'banknote');
    }
    public function categors(){
        return $this->belongsTo(Categor::class,'categor');
    }
}
