import { notFound } from "next/navigation";
import type { Metadata } from "next";
import { ChevronRight, FileText, Book } from "lucide-react";

type Props = {
  params: Promise<{
    slug: string[];
  }>;
};

// Mapeamento de conteúdo para cada página
const contentMap: {
  [key: string]: { title: string; content: string; description?: string };
} = {
  "estoque/funcoes/cadastrar-nota-fiscal": {
    title: "Cadastrar Nota Fiscal",
    description:
      "Documentação da função para cadastrar notas fiscais no sistema",
    content: `
## Função: cadastrarNotaFiscal
      
Esta função é responsável por cadastrar uma nova nota fiscal no sistema de estoque.
      
### Parâmetros
- **notaFiscal**: Objeto contendo os dados da nota fiscal
- **usuario**: ID do usuário que está cadastrando
      
### Retorno
Retorna o ID da nota fiscal cadastrada ou erro em caso de falha.
      
### Exemplo de uso
\`\`\`javascript
const resultado = await cadastrarNotaFiscal({
  numero: "12345",
  valor: 1500.00,
  fornecedor: "Fornecedor XYZ"
}, usuarioId);
\`\`\`
    `,
  },
  "estoque/funcoes/listar-nota-fiscal": {
    title: "Listar Notas Fiscais",
    description: "Documentação da função para listar todas as notas fiscais",
    content: `
## Função: listarNotaFiscal
      
Lista todas as notas fiscais cadastradas no sistema de estoque.
      
### Parâmetros
- **filtros** (opcional): Objeto com filtros para a busca
- **paginacao** (opcional): Configurações de paginação
      
### Retorno
Array com as notas fiscais encontradas.
    `,
  },
  "estoque/funcoes/listar-nota-fiscal-id": {
    title: "Listar Nota Fiscal por ID",
    description:
      "Documentação da função para buscar uma nota fiscal específica pelo ID",
    content: `
## Função: listarNotaFiscalId
      
Busca uma nota fiscal específica pelo seu ID.
      
### Parâmetros
- **id**: ID da nota fiscal a ser buscada
      
### Retorno
Objeto com os dados da nota fiscal ou null se não encontrada.

### Exemplo de uso
\`\`\`javascript
const notaFiscal = await listarNotaFiscalId("12345");
if (notaFiscal) {
  console.log("Nota fiscal encontrada:", notaFiscal);
} else {
  console.log("Nota fiscal não encontrada");
}
\`\`\`

### Possíveis erros
- **404**: Nota fiscal não encontrada
- **500**: Erro interno do servidor
    `,
  },
  "fiscal/functions/listar-nota-fiscal": {
    title: "Listar Nota Fiscal (Fiscal)",
    description: "Documentação da função fiscal para listar notas fiscais",
    content: `
## Função: listarNotaFiscal (Módulo Fiscal)
      
Versão específica do módulo fiscal para listagem de notas fiscais.
      
### Diferenças do módulo de estoque
- Inclui validações fiscais específicas
- Retorna dados formatados para relatórios fiscais
    `,
  },
  "fiscal/dto/nota-fiscal-request": {
    title: "NotaFiscalRequestDTO",
    description: "Estrutura do DTO para requisições de nota fiscal",
    content: `
## DTO: NotaFiscalRequestDTO
      
Data Transfer Object para requisições de nota fiscal.
      
### Estrutura
\`\`\`typescript
interface NotaFiscalRequestDTO {
  numero: string;
  serie: string;
  valor: number;
  dataEmissao: Date;
  fornecedor: {
    cnpj: string;
    nome: string;
  };
  itens: ItemNotaFiscalDTO[];
}
\`\`\`
    `,
  },
  "fiscal/dto/nota-fiscal-response": {
    title: "NotaFiscalResponseDTO",
    description: "Estrutura do DTO para respostas das notas fiscais",
    content: `
## Entity: NotaFiscalResponseDTO
      
Data Transfer Object para respostas das notas fiscais.
      
### Estrutura
\`\`\`Php
    class NotaFiscalResponseDTO {
      public int $id;
      public string $numero_nf;
      public string $numero_serie;
      public string $numero_folhas;
      public string $natureza_operacao;
      public string $data_emissao;
      public string $data_saida;
      public float $valor_total;
      public float $valor_desconto;
      public string $nome;
    }
\`\`\`
</br>
## toArray
### Prepara o objeto para ser convertido para o JSON de resposta.

</br>
# Detalhes
  <li>**id**: Id da nota fiscal
  <li>**numero_nf**: Número da nota fiscal
  <li>**numero_serie**: Série da nota fiscal
  <li>**data_emissao**: Data de emissão
  <li>**valor_total**: Valor total da nota fiscal
  <li>**valor_desconto**: Valor de desconto
  <li>**cliente**: Nome do cliente
</br>
## DetalhesArray
### Prepara o objeto para ser convertido para o JSON de resposta.
</br>
# Detalhes
  <li>**id**: Id da nota fiscal
  <li>**numero_nf**: Número da nota fiscal
  <li>**numero_serie**: Série da nota fiscal
  <li>**numero_folhas**: Número de folhas
  <li>**natureza_operacao**: Natureza da operação
  <li>**data_emissao**: Data de emissão
  <li>**data_saida**: Data de saída
  <li>**valor_total**: Valor total da nota fiscal
  <li>**valor_desconto**: Valor de desconto
  <li>**cliente**: Nome do cliente
`,
  },
  "fiscal/models/nota-fiscal-model": {
    title: "NotaFiscalModel",
    description: "Modelo de dados para nota fiscal no banco de dados",
    content: `
## Model: NotaFiscalModel
      
Modelo de dados para nota fiscal no banco de dados.
      
### Campos
- **id**: Identificador único
- **numero**: Número da nota fiscal
- **serie**: Série da nota fiscal
- **valor**: Valor total
- **status**: Status atual da nota
- **created_at**: Data de criação
- **updated_at**: Data de atualização
    `,
  },
};

function parseMarkdown(content: string): string {
  return content
    .replace(
      /^### (.*$)/gim,
      '<h3 class="text-xl font-semibold text-gray-200 mt-6 mb-3">$1</h3>'
    )
    .replace(
      /^## (.*$)/gim,
      '<h2 class="text-2xl font-bold text-white border-b border-gray-700 pb-2 mb-4 mt-8">$1</h2>'
    )
    .replace(
      /^# (.*$)/gim,
      '<h1 class="text-3xl font-bold text-white mb-4">$1</h1>'
    )

    .replace(
      /```(\w+)?\n([\s\S]*?)```/g,
      '<pre class="bg-gray-800 border border-gray-700 rounded-md pt-4 overflow-x-auto"><code class="text-gray-200 text-sm">$2</code></pre>'
    )

    .replace(
      /`([^`]+)`/g,
      '<code class="text-gray-200 bg-gray-800 rounded px-1 py-0.5 text-sm">$1</code>'
    )

    .replace(
      /\*\*(.*?)\*\*/g,
      '<strong class="font-semibold text-white">$1</strong>'
    )

    .replace(/^- (.*$)/gim, '<li class="text-gray-300">$1</li>')

    .replace(/\n\n/g, '</p><p class="text-gray-300">')

    .replace(/^(?!<[h|l|p|c])/gm, '<p class="text-gray-300">')
    .replace(/(?<!>)$/gm, "</p>")

    .replace(/<p class="text-gray-300 mb-4"><\/p>/g, "")
    .replace(/<p class="text-gray-300 mb-4">(<[h|l|c])/g, "$1")
    .replace(/(<\/[h|l|c][^>]*>)<\/p>/g, "$1");
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const path = slug.join("/");
  const content = contentMap[path];

  if (!content) {
    return {
      title: "Documentação não encontrada",
    };
  }

  return {
    title: `${content.title} | Documentação`,
    description: content.description || `Documentação para ${content.title}`,
  };
}

export default async function DocPage({ params }: Props) {
  const { slug } = await params;
  const path = slug.join("/");
  const content = contentMap[path];

  if (!content) {
    notFound();
  }

  const getDocInfo = () => {
    if (path.includes("/fiscal/funcoes/")) {
      return { docType: "Função", dev: "Luiz" };
    }
    if (path.includes("/fiscal/dto/")) {
      return { docType: "DTO", dev: "Luiz" };
    }
    if (path.includes("/fiscal/models/")) {
      return { docType: "Modelo", dev: "Luiz" };
    }
    return { docType: "Documentação", dev: "Luiz" };
  };

  const { docType } = getDocInfo();
  const { dev } = getDocInfo();
  const parsedContent = parseMarkdown(content.content);

  return (
    <div className="h-screen bg-[#0D1117] text-gray-200 overflow-y-auto scroll-hidden">
      <div className="max-w-4xl mx-auto py-8 px-4">
        <nav className="flex items-center text-sm text-gray-400 mb-6">
          <span className="flex items-center">
            <Book className="h-4 w-4 mr-1" />
            <span>Docs</span>
          </span>
          {slug.map((segment, index) => (
            <span key={index} className="flex items-center">
              <ChevronRight className="h-4 w-4 mx-1" />
              <span className="capitalize">{segment.replace(/-/g, " ")}</span>
            </span>
          ))}
        </nav>

        <div className="mb-8">
          <div className="flex items-center">
            <div className="inline-block bg-[#1A4B3A] text-green-100 text-xs font-medium px-2.5 py-1 rounded mb-2">
              {docType}
            </div>
            <div className="inline-block bg-[#1A4B3A] text-green-100 text-xs font-medium px-2.5 py-1 rounded ml-2 mb-2">
              {dev}
            </div>
          </div>
          <h1 className="text-3xl font-bold text-white mb-2">
            {content.title}
          </h1>
          {content.description && (
            <p className="text-gray-400 text-lg">{content.description}</p>
          )}
        </div>

        <div className="border-b border-gray-700 mb-8"></div>

        <div
          className="prose-custom max-w-none "
          dangerouslySetInnerHTML={{ __html: parsedContent }}
        />

        <div className="mt-12 pt-6 border-t border-gray-700 text-sm text-gray-400">
          <div className="flex items-center">
            <FileText className="h-4 w-4 mr-2" />
            <span>Última atualização: 07/06/2025</span>
          </div>
        </div>
      </div>
    </div>
  );
}
