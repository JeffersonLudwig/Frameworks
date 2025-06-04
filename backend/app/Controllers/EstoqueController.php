<?php

namespace App\Controllers;

use App\Models\EstoqueModel;

class EstoqueController extends BaseController
{
    public function index()
    {
        try {
            $model = new EstoqueModel();
            $estoques = $model->findAll();

            // DEBUG - escreve no arquivo de log customizado
            file_put_contents(WRITEPATH . 'debug_estoques.log', print_r($estoques, true));

            // Check if data exists
            if (empty($estoques)) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON(['status' => 'error', 'message' => 'No stock found']);
            }

            // Return JSON response properly
            return $this->response
                ->setStatusCode(200)
                ->setJSON([
                    'status' => 'success',
                    'data' => $estoques
                ]);
        } catch (\Exception $e) {
            // Log error to CodeIgniter's logger
            log_message('error', 'EstoqueController Error: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Internal server error'
                ]);
        }
    }
}
