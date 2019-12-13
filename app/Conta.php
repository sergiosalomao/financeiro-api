<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['banco_id','descricao'];

    public function lancamentos()
    {
        return $this->hasMany('App\Lancamento');
    }

    public function banco()
    {
        return $this->belongsTo('App\Banco');
    }


}

