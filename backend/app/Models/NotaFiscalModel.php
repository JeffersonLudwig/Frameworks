<?php

namespace App\Models;

use App\Enums\NotaFiscal;
use CodeIgniter\Model;

class NotaFiscalModel extends Model
{
    protected $table = 'notas_fiscais';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'numero_nf',
        'numero_serie',
        'numero_folhas',
        'natureza_operacao',
        'data_emissao',
        'data_saida',
        'valor_total',
        'valor_desconto',
        'status',
        'created_at',
        'updated_at',
        'cliente_id',
        'usuario_id',
        'estoque_id'
    ];

    public function cadastrarNotaFiscal(array $dados)
    {
        try {
            if (empty($dados['status'])) {
                $dados['status'] = NotaFiscal::Pendente->nome();
            }

            $notaExistente = $this->builder()
                ->where('numero_nf', $dados['numero_nf'])
                ->get()
                ->getRowArray();
            if ($notaExistente) {
                if ($notaExistente['usuario_id'] != $dados['usuario_id']) {
                    throw new \Exception('Nota fiscal já cadastrada por outro usuário.');
                } else {
                    throw new \Exception('Nota fiscal já cadastrada por você.');
                }
            }

            return $this->insert($dados);
        } catch (\Exception $e) {
            throw new \Exception('Erro ao cadastrar nota fiscal: ' . $e->getMessage());
        }
    }

    public function listarNotaFiscal(): array
    {
        $teste = $this->builder()
            ->select('notas_fiscais.*, clientes.nome AS nome')
            ->join('clientes', 'clientes.id = notas_fiscais.cliente_id', 'left')
            ->orderBy('notas_fiscais.data_emissao', 'CRESC')
            ->get()
            ->getResultArray();
        return $teste;
    }

    public function listarNotaFiscalId($id)
    {
        return $this->builder()
            ->select('notas_fiscais.*, clientes.nome')
            ->join('clientes', 'clientes.id = notas_fiscais.cliente_id', 'left')
            ->where('notas_fiscais.id', $id)
            ->get()
            ->getRowArray();
    }
    public function deletarNotaFiscal($id)
    {
        $nota = $this->builder()
            ->select('notas_fiscais.*', 'status')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$nota) {
            throw new \Exception('Nota fiscal nao encontrada.');
        }

        if ($nota['status'] == 'Enviada') {
            throw new \Exception('Nota fiscal enviada, nao pode ser excluida.');
        }
        $this->delete(['id' => $id]);
        return ['success' => true, 'message' => 'Nota fiscal excluída com sucesso.'];
    }
}
