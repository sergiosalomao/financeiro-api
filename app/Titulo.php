<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'cedente_id',
        'vencimento',
        'sacado',
        'conta_id',
        'fluxo_id',
        'valor',
        'tipo',
        'status'
    ];

    public function lancamentos()
    {
        return $this->hasMany('App\Lancamento');
    }

    public function conta()
    {
        return $this->belongsTo('App\Conta');
    }
    
    public function fluxo()
    {
        return $this->belongsTo('App\Fluxo');
    }

    public function cedente()
    {
        return $this->belongsTo('App\Cedente');
    }

}
