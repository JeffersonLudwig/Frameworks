<?php

namespace App\Controllers;

use App\Models\NotaFiscalModel;
use App\Models\NotaProdutoModel;
use App\Entities\Request\NotaFiscalRequestDTO;
use App\Entities\Response\NotaFiscalResponseDTO;
use App\Entities\Request\ProdutoNotaRequestDTO;
use App\Authentication\JwtService;

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

        $authHeader = $this->request->getHeaderLine('Authorization');
        if (strpos($authHeader, 'Bearer ') === 0) {
            $jwt = trim(str_replace('Bearer', '', $authHeader));
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Token JWT não fornecido ou em formato inválido.'
            ])->setStatusCode(401);
        }

        $jwtService = new JwtService(env('JWT_SECRET'));
        $claims = $jwtService->validarToken($jwt);
        if (!$claims || !isset($claims['uid'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Token inválido ou user_id ausente.'
            ])->setStatusCode(401);
        }
        $userId = $claims['uid'];
        $postData = $this->request->getJSON(true);
        $postData['usuario_id'] = $userId;

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
            'estoque_id'        => 'required',
            'usuario_id'        => 'required'
        ];

        $validationMessages = [
            'numero_nf' => ['required' => 'O campo número da nota fiscal é obrigatório.'],
            'numero_serie' => ['required' => 'O campo número de série é obrigatório.'],
            'numero_folhas' => ['required' => 'O campo número de folhas é obrigatório.'],
            'natureza_operacao' => ['required' => 'O campo natureza da operação é obrigatório.'],
            'cliente_id' => ['required' => 'O campo client_id é obrigatório.'],
            'estoque_id' => ['required' => 'O campo estoque_id é obrigatório.'],
            'usuario_id' => ['required' => 'Error: Entre em contato com o administrador.'],
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
            $errors = $this->validator->getErrors();

            if (isset($errors['usuario_id']) && $errors['usuario_id'] === 'Error: Entre em contato com o administrador.') {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Erro interno: campo usuario_id falhou inesperadamente.'
                ])->setStatusCode(500);
            }

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $errors
            ])->setStatusCode(400);
        }

        try {
            $notaFiscalDTO = new NotaFiscalRequestDTO($postData);
            $dadosSalvar = $notaFiscalDTO->toArray();

            $notaFiscalModel = new NotaFiscalModel();

            $notaFiscalModel->cadastrarNotaFiscal($dadosSalvar);
            if (isset($result['success']) && $result['success'] === false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result['message']
                ])->setStatusCode(400);
            }
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

    public function deletarNotaFiscal($id)
    {
        if (!$this->request->is('delete')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Método não permitido.'
            ])->setStatusCode(405);
        }

        try {
            $notaFiscalModel = new NotaFiscalModel();
            $notaFiscalModel->deletarNotaFiscal($id);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Nota Fiscal %s deletada com sucesso.',
                'id' => $id
            ])->setStatusCode(200);
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

        $postData = $this->request->getJSON(true);
        try {

            $notaFiscalDTO = new ProdutoNotaRequestDTO($postData);
            $dadosSalvar = $notaFiscalDTO->toArray();

            $notaFiscalModel = new NotaProdutoModel();

            $notaFiscalModel->inserirProdutoNaNotaFiscal($dadosSalvar);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produto inserido na nota fiscal com sucesso.'
            ])->setStatusCode(200);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
