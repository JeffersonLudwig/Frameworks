<?php

namespace App\Controllers;

use App\Models\EstoqueModel;
use App\Models\EstoqueProdutoModel;

class EstoqueController extends BaseController
{
    private $estoqueModel;
    private $estoqueProdutoModel;

    public function __construct()
    {
        $this->estoqueModel = new EstoqueModel();
        $this->estoqueProdutoModel = new EstoqueProdutoModel();
    }

    public function index()
    {
        return $this->response->setJSON($this->estoqueModel->findAll());
    }

    public function show($id = null)
    {
        $produtos = $this->estoqueProdutoModel->where('estoque_id', $id)->findAll();
        return $this->response->setJSON($produtos);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->estoqueModel->insert($data)) {
            return $this->response->setStatusCode(201)->setJSON($data);
        }
        return $this->response->setStatusCode(400)->setJSON($this->estoqueModel->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->estoqueModel->update($id, $data)) {
            return $this->response->setJSON($this->estoqueModel->find($id));
        }
        return $this->response->setStatusCode(400)->setJSON($this->estoqueModel->errors());
    }

    public function delete($id = null)
    {
        if ($this->estoqueModel->delete($id)) {
            return $this->response->setStatusCode(200)->setJSON(['id' => $id]);
        }
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Estoque não encontrado']);
    }

    public function adicionarProduto($estoqueId)
    {
        $data = $this->request->getJSON(true);
        $data['estoque_id'] = $estoqueId;

        $produtoExistente = $this->estoqueProdutoModel
            ->where('estoque_id', $estoqueId)
            ->where('produto_id', $data['produto_id'])
            ->first();

        if ($produtoExistente) {
            $novaQuantidade = $produtoExistente['quantidade'] + $data['quantidade'];
            if ($this->estoqueProdutoModel->update($produtoExistente['id'], ['quantidade' => $novaQuantidade])) {
                return $this->response->setJSON($this->estoqueProdutoModel->find($produtoExistente['id']));
            }
            return $this->response->setStatusCode(400)->setJSON($this->estoqueProdutoModel->errors());
        }

        if ($this->estoqueProdutoModel->insert($data)) {
            $id = $this->estoqueProdutoModel->getInsertID();
            return $this->response->setStatusCode(201)->setJSON($this->estoqueProdutoModel->find($id));
        }
        return $this->response->setStatusCode(400)->setJSON($this->estoqueProdutoModel->errors());
    }

    public function atualizarProduto($estoqueId, $produtoId)
    {
        $data = $this->request->getJSON(true);
        $produtoExistente = $this->estoqueProdutoModel
            ->where('estoque_id', $estoqueId)
            ->where('produto_id', $produtoId)
            ->first();

        if (!$produtoExistente) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado neste estoque']);
        }

        if ($this->estoqueProdutoModel->update($produtoExistente['id'], $data)) {
            return $this->response->setJSON($this->estoqueProdutoModel->find($produtoExistente['id']));
        }
        return $this->response->setStatusCode(400)->setJSON($this->estoqueProdutoModel->errors());
    }

    public function removerProduto($estoqueId, $produtoId)
    {
        $produtoExistente = $this->estoqueProdutoModel
            ->where('estoque_id', $estoqueId)
            ->where('produto_id', $produtoId)
            ->first();

        if (!$produtoExistente) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado neste estoque']);
        }

        if ($this->estoqueProdutoModel->delete($produtoExistente['id'])) {
            return $this->response->setStatusCode(200)->setJSON(['id' => $produtoExistente['id']]);
        }
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Não foi possível remover o produto do estoque']);
    }
}
