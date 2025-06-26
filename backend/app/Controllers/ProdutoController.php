<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
use App\Models\NotaProdutoModel;
use App\Entities\Request\ProdutoUpdateRequestDTO;
use App\Entities\Response\ProdutoEmNotaFiscalDTO;
use CodeIgniter\RESTful\ResourceController;

class ProdutoController extends BaseController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
    }

    public function index()
    {
        return $this->response->setJSON($this->produtoModel->findAll());
    }

    public function show($id = null)
    {
        $produto = $this->produtoModel->find($id);
        if ($produto) {
            return $this->response->setJSON($produto);
        }
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado']);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        $id = $this->produtoModel->insert($data);
        if ($this->produtoModel->errors()) {
            return $this->response->setStatusCode(400)->setJSON($this->produtoModel->errors());
        }
        $data['id'] = $id;
        return $this->response->setStatusCode(201)->setJSON($data);
    }

    public function update($id = null)
    {
        $produtoUpdateRequest = new ProdutoUpdateRequestDTO($this->request->getJSON(true));

        $notaProdutoModel = new NotaProdutoModel();
        $produtosEmNota = $notaProdutoModel->where('produto_id', $id)->findAll();

        if (!empty($produtosEmNota)) {
            $notasFiscaisDeSaida = [];
            $notaFiscalModel = new \App\Models\NotaFiscalModel();

            foreach ($produtosEmNota as $produtoEmNota) {
                $notaFiscal = $notaFiscalModel->find($produtoEmNota['nota_fiscal_id']);
                if ($notaFiscal && $notaFiscal['numero_serie'] == 1) { // Assumindo que 1 significa saída
                    $notasFiscaisDeSaida[] = $produtoEmNota['nota_fiscal_id'];
                }
            }

            if (!empty($notasFiscaisDeSaida)) {
                $produto = $this->produtoModel->find($id);

                $responseDTO = new ProdutoEmNotaFiscalDTO(
                    $produto['nome'],
                    array_unique($notasFiscaisDeSaida)
                );

                return $this->response->setStatusCode(409)->setJSON($responseDTO->toArray());
            }
        }

        $data = $produtoUpdateRequest->toArray();

        if ($this->produtoModel->update($id, $data) === false) {
            return $this->response->setStatusCode(400)->setJSON($this->produtoModel->errors());
        }

        return $this->response->setJSON($this->produtoModel->find($id));
    }

    public function delete($id = null)
    {
        if ($this->produtoModel->delete($id)) {
            return $this->response->setStatusCode(200)->setJSON(['id' => $id]);
        }
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Produto não encontrado']);
    }
}