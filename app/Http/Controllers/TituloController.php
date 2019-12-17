<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TituloRequest;
use App\Titulo;


class TituloController extends Controller
{

    public function index(Request $request, Titulo $titulo)
    {
        $dados = $titulo->newQuery();
        
        if ($request->filled('conta_id'))  $dados->where('conta_id', 'like', '%' . $request->conta_id . '%');
        if ($request->filled('fluxo_id'))  $dados->where('fluxo_id', 'like', '%' . $request->fluxo_id . '%');
        if ($request->filled('cedente_id'))  $dados->where('cedente_id', 'like', '%' . $request->cedente_id . '%');
        if ($request->filled('valor'))     $dados->where('valor', 'like', '%' . $request->valor . '%');
        
        if ($request->filled('datainicio','datafinal'))   
         $dados->whereBetween('vencimento', [$request->datainicio, $request->datafinal])->get();

        $dados = $dados->with(['conta', 'fluxo','cedente'])->orderBy('vencimento','desc')->get();
        
        return response()->json($dados, 200);
    }


    public function store(TituloRequest $request)
    {
        $dados = $request->all();
        try {
            $dados = Titulo::create($dados);
            return response()->json('Dados salvos', 200);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {
            $dados = Titulo::find($id);
            if (empty($dados)) {
                return response('registro nao encontrado.', 200);
            }
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response($dados);
    }


    public function update(TituloRequest $request, $id)
    {
        $param = $request->all();
        try {
            $dados = Titulo::findOrFail($id);
            $dados->update($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'DADOS' => $dados], 200);
    }


    public function destroy($id)
    {
        try {
            $dados = Titulo::find($id);
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
