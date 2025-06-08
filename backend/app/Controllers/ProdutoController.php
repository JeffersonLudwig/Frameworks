<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class ProdutoController extends ResourceController
{
    protected $modelName = ProdutoModel::class;
    protected $format    = 'json';

    // Lista todos os produtos
    public function index()
    {
        $produtos = $this->model->findAll();
        return $this->respond([
            'status' => 'success',
            'data'   => $produtos
        ]);
    }

    // Mostra produto pelo id
    public function show($id = null)
    {
        $produto = $this->model->find($id);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }
        return $this->respond([
            'status' => 'success',
            'data'   => $produto,
        ]);
    }

    // Cria produto novo
    public function create()
    {
        $data = $this->request->getJSON(true);
        if (!$this->model->insert($data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respondCreated([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    // Atualiza produto existente
    public function update($id = null)
    {
        $produto = $this->model->find($id);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }
        $data = $this->request->getJSON(true);
        if (!$this->model->update($id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }
        return $this->respond([
            'status' => 'success',
            'data'   => $data,
        ]);
    }

    // Deleta o produto
    public function delete($id = null)
    {
        $produto = $this->model->find($id);
        if (!$produto) {
            return $this->failNotFound('Produto não encontrado');
        }
        $this->model->delete($id);
        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Produto deletado',
        ]);
    }
}
