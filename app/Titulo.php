<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulo extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        'cedente',
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
}
