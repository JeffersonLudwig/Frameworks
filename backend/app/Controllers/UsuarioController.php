<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    public function index()
    {
        $model = new UsuarioModel();
        $data['usuarios'] = $model->findAll();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
