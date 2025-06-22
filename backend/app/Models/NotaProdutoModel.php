<?php

namespace App\Models;

use App\Models\NotaFiscalModel;
use CodeIgniter\Model;

class NotaProdutoModel extends Model
{
    protected $table = 'notas_fiscais';
    protected $useTimestamps = true;
    protected $allowedFields = ['nota_fiscal_id', 'produto_id', 'quantidade', 'valor_unitario'];


    public function inserirProdutoNaNotaFiscal(array $dados)
    {
        $quantidadePadrao = 1;

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
            $quantidade = $dados['quantidade'] ?? $quantidadePadrao;
            $novaQuantidade = $produtoExistente['quantidade'] + $quantidade;

            $this->db->table('notas_fiscais_produtos')
                ->where('id', $produtoExistente['id'])
                ->update([
                    'quantidade' => $novaQuantidade,
                ]);
        } else {
            $dadosParaInsercao = [
                'nota_fiscal_id' => $dados['nota_fiscal_id'],
                'produto_id'     => $dados['produto_id'],
                'quantidade'     => $dados['quantidade'] ?? $quantidadePadrao,
                'valor_unitario' => $dados['valor_unitario'],
            ];

            $this->db->table('notas_fiscais_produtos')->insert($dadosParaInsercao);
        }

        $notaFiscalModel = new NotaFiscalModel();
        $notaFiscalModel->atualizarValorTotalNotaFiscal(
            $dados['nota_fiscal_id'],
            ['valor_unitario' => $dados['valor_unitario']]
        );
    }
}
