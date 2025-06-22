<?php

namespace App\Controllers;

use App\Models\NotaFiscalModel;
use App\Models\NotaProdutoModel;
use App\Entities\Request\NotaFiscalRequestDTO;
use App\Entities\Response\NotaFiscalResponseDTO;
use App\Entities\Request\ProdutoEmNotaFiscalDTO;

class NotaFiscalController extends BaseController
{
    public function cadastrarNotaFiscal()
    {
        if (!$this->request->is('post')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não permitido.'
            ])->setStatusCode(405);
        }

        $postData = $this->request->getJSON(true);

        $validationRules = [
            'numero_nf'         => 'required',
            'numero_serie'      => 'required',
            'numero_folhas'     => 'required',
            'natureza_operacao' => 'required',
            'data_emissao'      => 'required|valid_date',
            'data_saida'        => 'required|valid_date',
            'valor_total'       => 'required|decimal',
            'valor_desconto'    => 'required|decimal',
            'cliente_id'        => 'required',
        ];

        $validationMessages = [
            'numero_nf' => ['required' => 'O campo número da nota fiscal é obrigatório.'],
            'numero_serie' => ['required' => 'O campo número de série é obrigatório.'],
            'numero_folhas' => ['required' => 'O campo número de folhas é obrigatório.'],
            'natureza_operacao' => ['required' => 'O campo natureza da operação é obrigatório.'],
            'cliente_id' => ['required' => 'O campo client_id é obrigatório.'],
            'data_emissao' => [
                'required' => 'A data de emissão é obrigatória.',
                'valid_date' => 'A data de emissão deve estar em formato válido.'
            ],
            'data_saida' => [
                'required' => 'A data de saída é obrigatória.',
                'valid_date' => 'A data de saída deve estar em formato válido.'
            ],
            'valor_total' => [
                'required' => 'O valor total é obrigatório.',
                'decimal' => 'O valor total deve ser um número decimal.'
            ],
            'valor_desconto' => [
                'required' => 'O valor de desconto é obrigatório.',
                'decimal' => 'O valor de desconto deve ser um número decimal.'
            ],
        ];

        if (!$this->validateData($postData, $validationRules, $validationMessages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ])->setStatusCode(422);
        }

        try {
            $notaFiscalDTO = new NotaFiscalRequestDTO($postData);
            $dadosSalvar = $notaFiscalDTO->toArray();

            $notaFiscalModel = new NotaFiscalModel();
            $notaFiscalModel->cadastrarNotaFiscal($dadosSalvar);

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $dadosSalvar
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function listarNotaFiscal()
    {
        if (!$this->request->is('get')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não permitido.'
            ])->setStatusCode(405);
        }

        try {
            $notaFiscalModel = new NotaFiscalModel();
            $registros =  $notaFiscalModel->listarNotaFiscal();

            $resultados = [];

            foreach ($registros as $registro) {
                $dto = new NotaFiscalResponseDTO($registro);
                $resultados[] = $dto->toArray();
            }

            return $this->response
                ->setJSON([
                    'status' => 'success',
                    'data' => $resultados
                ])
                ->setStatusCode(200);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function listarNotaFiscalId($id)
    {
        if (!$this->request->is('get')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não permitido.'
            ])->setStatusCode(405);
        }

        try {
            $notaFiscalModel = new NotaFiscalModel();
            $registro = $notaFiscalModel->listarNotaFiscalId($id);
            if (!$registro) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Nota Fiscal não encontrada.'
                ])->setStatusCode(404);
            }

            $dto = new NotaFiscalResponseDTO($registro);

            return $this->response
                ->setJSON([
                    'status' => 'success',
                    'data' => $dto->detalhesArray()
                ])
                ->setStatusCode(200);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function inserirProdutoNaNotaFiscal()
    {
        if (!$this->request->is('post')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não permitido.'
            ])->setStatusCode(405);
        }

        try {
            $dados = $this->request->getJSON(true); // Recebe array de dados
            $notaFiscalId = (int) $dados['nota_fiscal_id'];
            $dto = new ProdutoEmNotaFiscalDTO($dados); // Cria DTO com validação

            $notaProdutoModel = new NotaProdutoModel();
            $notaProdutoModel->inserirProdutoNaNotaFiscal($dto->toArray($notaFiscalId));
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produto inserido na nota fiscal com sucesso.'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
