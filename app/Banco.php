<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['numero','descricao'];

    public function Contas()
    {
        return $this->hasMany('App\Conta');
    }

}

