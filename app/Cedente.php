<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cedente extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['descricao'];

    public function lancamentos()
    {
        return $this->hasMany('App\Lancamento');
    }
}

