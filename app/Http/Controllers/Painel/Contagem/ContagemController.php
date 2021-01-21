<?php

namespace App\Http\Controllers\Painel\Contagem;

use App\Http\Controllers\Controller;
use App\Models\Painel\Contagem\Contagem;
use Illuminate\Http\Request;

class ContagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = 'Meus Controles';
        return view('contagem.table',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Fazer Contagem';
        return view('contagem.form',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Painel\Contagem\Contagem  $contagem
     * @return \Illuminate\Http\Response
     */
    public function show(Contagem $contagem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Painel\Contagem\Contagem  $contagem
     * @return \Illuminate\Http\Response
     */
    public function edit(Contagem $contagem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Painel\Contagem\Contagem  $contagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contagem $contagem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Painel\Contagem\Contagem  $contagem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contagem $contagem)
    {
        //
    }
}
