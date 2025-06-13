<?php

namespace App\Controllers;

use App\Models\EstoqueProdutoModel;
use CodeIgniter\Controller;

class EstoqueProdutoController extends Controller
{
    public function index()
    {
        $model = new EstoqueProdutoModel();
        $data['produtos'] = $model->findAll();
        return view('estoque/lista', $data);
    }

    public function criar()
    {
        return view('estoque/form');
    }

    public function salvar()
    {
        $model = new EstoqueProdutoModel();

        $data = [
            'estoque_id' => $this->request->getPost('estoque_id'),
            'produto_id' => $this->request->getPost('produto_id'),
            'quantidade' => $this->request->getPost('quantidade'),
            'preco'      => $this->request->getPost('preco'),
        ];

        if (!$model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/estoque');
    }
}