<?php

namespace App\Http\Controllers\Painel\Contagem;

use App\Http\Controllers\Controller;
use App\Models\Painel\Contagem\Banknote;
use Illuminate\Http\Request;

class BankNotesController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public static function store($dados)
    {
        return Banknote::create($dados);
    }

    
    public function show(Banknote $banknote)
    {
        //
    }

    public function edit(Banknote $banknote)
    {
        //
    }

   
    public function update(Request $request, Banknote $banknote)
    {
        //
    }

    public function destroy(Banknote $banknote)
    {
        //
    }
}
