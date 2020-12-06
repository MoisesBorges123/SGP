<?php

namespace App\Http\Controllers\Painel\Celebracoes;

use App\Http\Controllers\Controller;
use App\Models\Painel\Celevracoes\IntentionScope;
use Illuminate\Http\Request;

class ScopeController extends Controller
{
   
    public function store($dados)
    {
        $intentionScope = new IntentionScope;
        return $intentionScope->create($dados);
    }

    public function show(IntentionScope $intentionScope)
    {
        //
    }
    
    public function update(Request $request, IntentionScope $intentionScope)
    {
        //
    }

    public function destroy(IntentionScope $intentionScope)
    {
        //
    }
}
