<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LancamentoRequest;
use App\Lancamento;
use App\Conta;
use App\Fluxo;

class LancamentoController extends Controller
{

    public function index(Request $request, Lancamento $lancamento)
    {
        $dados = $lancamento->newQuery();
        if ($request->filled('descricao')) $dados->where('descricao', 'like', '%' . $request->descricao . '%');
        if ($request->filled('conta_id'))  $dados->where('conta_id', 'like', '%' . $request->conta_id . '%');
        if ($request->filled('fluxo_id'))  $dados->where('fluxo_id', 'like', '%' . $request->fluxo_id . '%');
        if ($request->filled('valor'))     $dados->where('valor', 'like', '%' . $request->valor . '%');
        if ($request->filled('descricao')) $dados->where('descricao', 'like', '%' . $request->descricao . '%');
        if ($request->filled('titulo'))    $dados->where('titulo_id', 'like', '%' . $request->titulo . '%');
        if ($request->filled('datainicio','datafinal'))   
         $dados->whereBetween('data_lancamento', [$request->datainicio, $request->datafinal])->get();

        $dados = $dados->with(['conta', 'fluxo','titulo'])->orderBy('data_lancamento','desc')->get();

        // $total = 0;
        // foreach($dados as $dado){
        //     if($dado->tipo =='Debito')
        //         $total -= $dado->valor;
        //         else
        //         if($dado->tipo =='Credito'){
        //             $total += $dado->valor;
        //         }
        //     }

        // $dados['total'] = $total;
        
        return response()->json($dados, 200);
    }


    public function store(LancamentoRequest $request)
    {
        $dados = $request->all();
        try {
            $dados = Lancamento::create($dados);
            return response()->json('Dados salvos', 200);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {
            $dados = Lancamento::with(['conta', 'fluxo'])->findOrFail($id);
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
            $dados = Lancamento::findOrFail($id);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        $dados->update($param);
        return response()->json(['Dados atualizados', 'DADOS' => $dados], 200);
    }


    public function destroy($id)
    {
        try {
            $dados = Lancamento::find($id);
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
