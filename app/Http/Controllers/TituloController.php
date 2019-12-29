<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TituloRequest;
use App\Titulo;
use App\Lancamento;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class TituloController extends Controller
{

    public function index(Request $request, Titulo $titulo)
    {
        $dados = $titulo->newQuery();
        if ($request->filled('informacoes')) {
            $dados = $dados->get();
            return $this->getInformacoes($dados);
        }


        $dados = $titulo->newQuery();

        if ($request->filled('status'))  $dados->where('status', 'like', '%' . $request->status . '%');
        if ($request->filled('conta_id'))  $dados->where('conta_id', 'like', '%' . $request->conta_id . '%');
        if ($request->filled('fluxo_id'))  $dados->where('fluxo_id', 'like', '%' . $request->fluxo_id . '%');
        if ($request->filled('cedente_id'))  $dados->where('cedente_id', 'like', '%' . $request->cedente_id . '%');
        if ($request->filled('valor'))     $dados->where('valor', 'like', '%' . $request->valor . '%');

        if ($request->filled('datainicio', 'datafinal'))
            $dados->whereBetween('vencimento', [implode('-', array_reverse(explode('/', $request->datainicio))), implode('-', array_reverse(explode('/', $request->datafinal)))])->get();

        $dados = $dados->with(['conta', 'fluxo', 'cedente'])->orderBy('vencimento', 'asc')->get();

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
            $dados = Titulo::with(['conta', 'fluxo', 'cedente'])->find($id);
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


            if ($dados->status == 'Pago')
                $this->criarLancamento($dados);
            else if ($dados->status == 'Aberto')
                $this->apagarLancamento($id);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'DADOS' => $dados], 200);
    }

    private function apagarLancamento($tituloId)
    {
        $dados = Lancamento::where('titulo_id', $tituloId);
        $dados->delete();
    }

    private function criarLancamento($dados)
    {
        try {
            $lanc = new Lancamento;
            $lanc->data_lancamento = date("Y/m/d");
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
    public function getInformacoes($dados)
    {



        $total['totalPago'] = 0;
        $total['totalApagar'] = 0;
        $total['totalRecebido'] = 0;
        $total['totalAReceber'] = 0;


        foreach ($dados as $dado) {
            if (($dado['status'] == "Pago") && ($dado['tipo'] == "Debito")) {
                $total['totalPago'] += $dado['valor'];
            }
            if (($dado['status'] == "Aberto") && ($dado['tipo'] == "Debito")) {
                $total['totalApagar'] += $dado['valor'];
            }

            if (($dado['status'] == "Pago") && ($dado['tipo'] == "Credito")) {
                $total['totalRecebido'] += $dado['valor'];
            }

            if (($dado['status'] == "Aberto") && ($dado['tipo'] == "Credito")) {
                $total['totalAReceber'] += $dado['valor'];
            }
        }

        $totalArray = array(
            "totalApagar" => [
                "text" => "Total a Pagar",
                "value" => $total['totalApagar'],
            ],
            "totalAReceber" => [
                "text" => "Total a Receber",
                "value" => $total['totalAReceber'],
            ],
            "totalPago" => [
                "text" => "Total Pago",
                "value" => $total['totalPago'],
            ],
            "totalRecebido" => [
                "text" => "Total Recebido",
                "value" => $total['totalRecebido'],
            ],

        );

        return $totalArray;
    }
}
