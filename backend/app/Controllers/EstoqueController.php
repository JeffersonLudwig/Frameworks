<?php

namespace App\Controllers;

use App\Models\EstoqueModel;

class EstoqueController extends BaseController
{
    public function index()
    {
        return $this->response->setJSON(['message' => 'Usuários retornados com sucesso.']);
    }
}
