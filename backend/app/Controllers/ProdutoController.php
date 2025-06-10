<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\Request\ProdutoUpdateRequestDTO;
use App\Entities\Response\ProdutoEmNotaFiscalDTO;

class ProdutoController extends ResourceController
{
    protected $modelName = ProdutoModel::class;
    protected $format    = 'json';

    // ... (métodos index, show, create, delete - permanecem iguais)

    // Atualiza produto existente
    public function update($id = null)
    {
        $produto = $this->model->find($id);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }

        $jsonData = $this->request->getJSON(true);
        $produtoUpdateDTO = new ProdutoUpdateRequestDTO($jsonData);
        $data = $produtoUpdateDTO->toArray();

        $notasFiscais = $this->model->produtoEmNotaFiscalSaida($id);

        if (!empty($notasFiscais)) {
            $listaNotas = [];
            foreach ($notasFiscais as $nota) {
                $produtoDTO = new ProdutoEmNotaFiscalDTO($produto['nome'], $nota['nota_fiscal_id']);
                $listaNotas[] = $produtoDTO->toArray();
            }

            return $this->respond([
                'status' => 'warning',
                'message' => 'Produto associado a notas fiscais de saída.',
                'data' => $listaNotas,
            ], 400);
        }

        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond([
            'status' => 'success',
            'message' => 'Produto atualizado com sucesso.',
            'data'   => $data,
        ]);
    }
}
