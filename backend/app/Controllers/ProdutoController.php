<?php

namespace App\Controllers;

use App\Entities\Request\ProdutoUpdateRequestDTO;
use App\Entities\Response\ProdutoEmNotaFiscalDTO;
use App\Models\NotaProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class ProdutoController extends ResourceController
{
    protected $modelName = 'App\Models\ProdutoModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $produto = $this->model->find($id);
        if ($produto) {
            return $this->respond($produto);
        }
        return $this->failNotFound('Produto não encontrado');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        $id = $this->model->insert($data);
        if ($this->model->errors()) {
            return $this->fail($this->model->errors());
        }
        $data['id'] = $id;
        return $this->respondCreated($data);
    }

    public function update($id = null)
    {
        $produtoUpdateRequest = new ProdutoUpdateRequestDTO($this->request->getJSON(true));

        $notaProdutoModel = new NotaProdutoModel();
        $produtosEmNota = $notaProdutoModel->where('produto_id', $id)->findAll();

        if (!empty($produtosEmNota)) {
            $notaFiscalModel = new \App\Models\NotaFiscalModel();

            foreach ($produtosEmNota as $produtoEmNota) {
                $notaFiscal = $notaFiscalModel->find($produtoEmNota['nota_fiscal_id']);
                if ($notaFiscal && $notaFiscal['numero_serie'] == 1) {
                    $produto = $this->model->find($id);

                    $responseDTO = new ProdutoEmNotaFiscalDTO(
                        $produto['nome'],
                        $produtoEmNota['nota_fiscal_id']
                    );

                    return $this->fail($responseDTO->toArray(), 409);
                }
            }
        }

        $data = $produtoUpdateRequest->toArray();

        if ($this->model->update($id, $data) === false) {
            return $this->fail($this->model->errors());
        }

        return $this->respond($this->model->find($id));
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failNotFound('Produto não encontrado');
    }
}