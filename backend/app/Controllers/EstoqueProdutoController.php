<?php

namespace App\Controllers;

use App\Models\EstoqueProdutoModel;
use CodeIgniter\RESTful\ResourceController;

class EstoqueProdutoController extends ResourceController
{
    protected $modelName = EstoqueProdutoModel::class;
    protected $format    = 'json';

    public function index()
    {
        return $this->respond([
            'status' => 'success',
            'data'   => $this->model->findAll()
        ]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond([
                'status' => 'success',
                'data'   => $data
            ]);
        }
        return $this->failNotFound('Registro não encontrado.');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            $response = [
                'status'   => 'success',
                'messages' => ['Registro criado com sucesso.'],
                'data'     => $data
            ];
            return $this->respondCreated($response);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            $response = [
                'status'   => 'success',
                'messages' => ['Registro atualizado com sucesso.'],
                'data'     => $data
            ];
            return $this->respond($response);
        }
        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted(['messages' => ['Registro deletado com sucesso.']]);
        }
        return $this->failNotFound('Registro não encontrado.');
    }
}
