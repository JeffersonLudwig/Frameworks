<?php

namespace App\Models;

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
        'created_at',
        'updated_at',
        'cliente_id'
    ];

    public function cadastrarNotaFiscal(array $dados)
    {
        unset($dados['created_at']);
        return $this->insert($dados);
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

    public function atualizarValorTotalNotaFiscal($id, array $dados)
    {
        $valor_total = 0;
        if (!isset($dados['valor_unitario'])) {
            return false;
        }

        $nota = $this->builder()
            ->select('notas_fiscais.*', 'status', 'valor_total')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$nota) {
            throw new \Exception('Nota fiscal nao encontrada.');
        }

        if ($nota['status'] == 'Enviada') {
            throw new \Exception('Nota fiscal enviada, nao pode ser alterada.');
        }

        if ($nota['status'] == 'Cancelada') {
            throw new \Exception('Nota fiscal cancelada, nao pode ser alterada.');
        }

        $itens = $this->db->table('notas_fiscais_produtos')
            ->select('notas_fiscais_produtos.*, produtos.nome as produto_nome')
            ->join('produtos', 'produtos.id = notas_fiscais_produtos.produto_id')
            ->where('nota_fiscal_id', $id)
            ->get()
            ->getResultArray();
        $nota['itens'] = $itens;

        foreach ($itens as $item) {
            $valor_total += $item['valor_unitario'] * $item['quantidade'];
        }

        return $this->update($id, ['valor_total' => $valor_total]);
    }
}
