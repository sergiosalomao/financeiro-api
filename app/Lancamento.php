<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    protected $hidden = ['created_at', 'updated_at'];
    
    protected $fillable = ['tipo', 'conta_id', 'fluxo_id', 'valor', 'status', 'descricao', 'titulo_id'];

    public function conta()
    {
        return $this->belongsTo('App\Conta');
    }
    
    public function fluxo()
    {
        return $this->belongsTo('App\Fluxo');
    }

    public function titulo()
    {
        return $this->belongsTo('App\Titulo');
    }
}
