<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContaRequest;
use App\Conta;
use Illuminate\Support\Facades\DB;

class ContaController extends Controller
{

    public function index(Request $request, Conta $conta)
    {
        $dados = $conta->newQuery();
        if ($request->filled('descricao')) {
            $dados->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        $dados = $conta->newQuery();
        if ($request->filled('banco_id')) {
            $dados->where('banco_id', 'like', '%' . $request->banco_id . '%');
        }
       
        // $dados = DB::table('contas')
        // ->join('bancos', 'bancos.id', '=', 'contas.banco_id')
        // ->get();
        $dados = $dados->with('banco')->get();
        

        if ($dados->count() == 0) {
            return response('Nenhum dado encontrado.', 200);
        }

        return response()->json($dados, 200);
    }


    public function store(ContaRequest $request)
    {
        $param = $request->all();
        try {
            $dados = Conta::create($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json('Dados salvos', 200);
    }


    public function show($id)
    {
        try {
            $dados = Conta::find($id);
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
            $dados = Conta::findOrFail($id);
            $dados->update($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'Dados' => $dados], 200);
    }


    public function destroy($id)
    {
        try {
            $dados = Conta::find($id);
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
