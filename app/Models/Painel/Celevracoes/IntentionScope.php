<?php

namespace App\Models\Painel\Celevracoes;

use Illuminate\Database\Eloquent\Model;

class IntentionScope extends Model
{
    //
    protected $table = 'intention_scopes';
    protected $fillable =[ 
        'date_schedule',
        'time_schedule',
        'claimant',
        'observations',
        'classification',
        'complement',
    ];
}
