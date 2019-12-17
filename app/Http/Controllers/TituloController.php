<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TituloRequest;
use App\Titulo;
use App\Lancamento;

class TituloController extends Controller
{

    public function index(Request $request, Titulo $titulo)
    {
        $dados = $titulo->newQuery();
        
        if ($request->filled('status'))  $dados->where('status', 'like', '%' . $request->status . '%');
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

           
                $this->criarLancamento($dados);
           
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'DADOS' => $dados], 200);
    }

    private function apagarLancamento($dados)
    {
        $dados = Lancamento::find($dados);
        $dados->delete();     
    }

    private function criarLancamento($dados)
    {
        try {
            
            $lanc = new Lancamento;
            
            $lanc->data_lancamento = date("d/m/Y");
            $lanc->tipo = $dados->tipo;
            $lanc->conta_id = $dados->conta_id;
            $lanc->fluxo_id = $dados->fluxo_id;
            $lanc->titulo_id = $dados->id;
            $lanc->valor = $dados->valor;
            $lanc->descricao = "Baixa de boleto";
            $lanc->save();
            return response()->json('Dados salvos', 200);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
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
