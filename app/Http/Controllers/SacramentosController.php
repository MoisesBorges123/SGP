<?php

namespace App\Http\Controllers;
use Models\Painel\Sacramento;
use Illuminate\Http\Request;

class SacramentosController extends Controller
{   
    private $sacramento;
    public function __construct(Sacramento $sacrament)
    {
        $this->sacramento = $sacrament;
    }
    public function index(){
        $dados = $this->sacramento->all();
        return json_decode($dados);
    }
}
