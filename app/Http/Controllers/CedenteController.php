<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CedenteRequest;
use App\Cedente;

class CedenteController extends Controller
{

    public function index(Request $request, Cedente $cedente)
    {
        $dados = $cedente->newQuery();
        if ($request->filled('descricao')) {
            $dados->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        
        $dados = $dados->get();

        
        return response()->json($dados, 200);
    }


    public function store(CedenteRequest $request)
    {
        $param = $request->all();
        try {
            $dados = Cedente::create($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json('Dados salvos', 200);
    }


    public function show($id)
    {
        try {
            $dados = Cedente::find($id);
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
            $dados = Cedente::findOrFail($id);
            $dados->update($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'DADOS' => $dados], 200);
    }


    public function destroy($id)
    {
        try {
            $dados = Cedente::find($id);
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
