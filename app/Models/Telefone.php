<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    //
    protected $table = 'telefone';
    protected $filable = ['numero','pessoa','created_at','updated_at'];
}
