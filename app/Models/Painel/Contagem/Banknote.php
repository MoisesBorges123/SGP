<?php

namespace App\Models\Painel\Contagem;

use Illuminate\Database\Eloquent\Model;

class Banknote extends Model
{
    //
    public $fillable = [
        'n2',
        'n5',
        'n10',
        'n20',
        'n50',
        'n100',
        'check_paper'
    ];
}
