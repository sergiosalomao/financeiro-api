<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BancoRequest;
use App\Banco;

class BancoController extends Controller
{

    public function index(Request $request, Banco $banco)
    {
        $dados = $banco->newQuery();
        if ($request->filled('descricao')) {
            $dados->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        if ($request->filled('numero')) {
            $dados->where('numero', 'like', '%' . $request->numero . '%');
        }

        if ($request->filled('agencia')) {
            $dados->where('agencia', 'like', '%' . $request->agencia . '%');
        }

        $dados = $dados->with(['contas'])->get();
        //$dados = $dados->get();
        
        return response()->json($dados, 200);
    }


    public function store(BancoRequest $request)
    {
        $param = $request->all();
        try {
            $dados = Banco::create($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json('Dados salvos', 200);
    }


    public function show($id)
    {
        try {
            $dados = Banco::find($id);
            if (empty($dados)) {
                return response('registro nao encontrado.', 200);
            }
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }

        return response($dados);
    }


    public function update(Request $request, $id)
    {
        $param = $request->all();
        try {
            $dados = Banco::findOrFail($id);
            $dados->update($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'Dados' => $dados], 200);
    }


    public function destroy($id)
    {
        try {
            $dados = Banco::find($id);
            if (empty($dados)) {
                return response('registro nao encontrado.', 200);
            }
            $dados->delete();           
            return response()->json(['Dados excluidos', 'DADOS' => $dados], 200);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
    }
}
