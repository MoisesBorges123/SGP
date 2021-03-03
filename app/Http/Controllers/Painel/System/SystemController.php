<?php

namespace App\Http\Controllers\Painel\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    //
    public function mensWorking(){
        return view('system.working');
    }
}
