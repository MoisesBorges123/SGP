<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $table = 'telefone';
    public $fillable = ['telefone','pessoa'];
}
