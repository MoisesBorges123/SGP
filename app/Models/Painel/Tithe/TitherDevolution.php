<?php

namespace App\Models\Painel\Tithe;

use Illuminate\Database\Eloquent\Model;

class TitherDevolution extends Model
{
    //
    protected $table = 'tither_devolutions';
    public $fillable = ['tither','amoutn','month','year','location'];
}
