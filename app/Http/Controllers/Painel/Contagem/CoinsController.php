<?php

namespace App\Http\Controllers\Painel\Contagem;

use App\Http\Controllers\Controller;
use App\Models\Painel\Contagem\Coin;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public static function store($dados)
    {
        return Coin::create($dados);
    }
   
    public function show(Coin $coin)
    {
        //
    }

    public function edit(Coin $coin)
    {
        //
    }
    public static function update($request)
    {
        $coin = Coin::find($request['id']);
        return $coin->update($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Painel\Contagem\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        //
    }
}
