<?php

namespace App\Models;

use CodeIgniter\Model;

class NotaProdutoModel extends Model
{
    protected $table = 'notas_fiscais';
    protected $useTimestamps = true;
    protected $allowedFields = ['nota_fiscal_id', 'produto_id', 'quantidade', 'valor_unitario'];


    public function inserirProdutoNaNotaFiscal(array $dados)
    {
        $quantidadeInicial = 1;

        $produtoExistente = $this->db->table('notas_fiscais_produtos')
            ->where('nota_fiscal_id', $dados['nota_fiscal_id'])
            ->where('produto_id', $dados['produto_id'])
            ->get()
            ->getRowArray();

        $notaFiscal = $this->db->table('notas_fiscais')
            ->where('id', $dados['nota_fiscal_id'])
            ->get()
            ->getRowArray();

        if (!$notaFiscal) {
            throw new \Exception('Nota fiscal não encontrada.');
        }

        if ($notaFiscal['status'] === 'Enviada') {
            throw new \Exception('Nota fiscal enviada, não pode ser alterada.');
        }

        if ($produtoExistente) {
            $novaQuantidade = $produtoExistente['quantidade'] + ($dados['quantidade'] ?? $quantidadeInicial);
            $this->db->table('nota_fiscal_produtos')
                ->where('id', $produtoExistente['id'])
                ->update([
                    'quantidade' => $novaQuantidade,
                    'valor_total' => $novaQuantidade * $dados['valor_unitario'],
                ]);

            return true;
        }

        $quantidadeFinal = $dados['quantidade'] ?? $quantidadeInicial;
        $dados['valor_total'] = $quantidadeFinal * $dados['valor_unitario'];
        $dados['quantidade'] = $quantidadeFinal;

        return $this->db->table('nota_fiscal_produtos')->insert($dados);
    }
}
