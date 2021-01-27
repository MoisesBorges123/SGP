<?php

namespace App\Models\Painel\Contagem;

use Illuminate\Database\Eloquent\Model;

class Banknote extends Model
{
    //
    public $fillable = [
        '2',
        '5',
        '10',
        '20',
        '50',
        '100',
        'check'
    ];
}
