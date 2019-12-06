<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fluxo extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['descricao','tipo'];

    public function lancamentos()
    {
        return $this->hasMany('App\Lancamento');
    }
}

