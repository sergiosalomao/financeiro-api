<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['diasatraso'];

    protected $fillable = [
        'cedente_id',
        'vencimento',
        'sacado',
        'conta_id',
        'fluxo_id',
        'valor',
        'tipo',
        'status',
        'data_pagamento'
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

    public function getDiasAtrasoAttribute()
    {
        if ($this->status == 'Aberto')
        $diferenca = strtotime($this->vencimento) - strtotime(date('Y-m-d'));
       if ($this->status == 'Pago')
        $diferenca = strtotime($this->vencimento) - strtotime($this->data_pagamento);
        return $this->attributes['diasatraso'] = floor($diferenca / (60 * 60 * 24));
    }

    // public function getVencimentoAttribute()
    // {
    //     return implode('/', array_reverse(explode('-', $this->attributes['vencimento'])));
    // }

    public function setVencimentoAttribute($value)
    {
        $this->attributes['vencimento'] = implode('-', array_reverse(explode('/', $value)));
    }

}
