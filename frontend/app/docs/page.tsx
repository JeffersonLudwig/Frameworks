export default function DocsHomePage() {
  return (
    <div className="max-w-4xl mx-auto overflow-hidden">
      <h1 className="text-4xl font-bold text-gray-900 mb-6">
        Bem-vindo à Documentação
      </h1>
      <div className="prose prose-lg">
        <p>
          Selecione um item no menu lateral para visualizar a documentação
          específica.
        </p>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
          <div className="p-6 border rounded-lg bg-[#080A13]">
            <h3 className="text-xl font-semibold text-amber-900 mb-3">
              Módulo Estoque
            </h3>
            <p className="text-amber-800">
              Documentação das funções relacionadas ao controle de estoque e
              notas fiscais.
            </p>
          </div>
          <div className="p-6 border border-amber-200 rounded-lg bg-[#080A13]">
            <h3 className="text-xl font-semibold text-amber-900 mb-3">
              Módulo Fiscal
            </h3>
            <p className="text-amber-800">
              Documentação das funções, DTOs e modelos do sistema fiscal.
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
