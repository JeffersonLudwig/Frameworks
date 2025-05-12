import { Menu, Sidebar } from "@/components/menu";

export default function PerfilModal() {
  return (
    <div className="flex overflow-hidden">
      <div className="h-screen">
        <Menu />
      </div>
      <div className="w-full">
        <Sidebar />
        <div className="flex flex-col bg-white rounded-lg p-6">
          <h2 className="text-xl font-bold mb-4">Editar Perfil</h2>
          <form className="flex flex-col gap-4">
            <input
              type="text"
              placeholder="Nome"
              className="border p-2 rounded"
            />
            <input
              type="email"
              placeholder="Email"
              className="border p-2 rounded"
            />
            <div className="flex justify-end gap-2 mt-4">
              <button type="button" className="px-4 py-2 bg-gray-300 rounded">
                Cancelar
              </button>
              <button
                type="submit"
                className="px-4 py-2 bg-blue-600 text-white rounded"
              >
                Salvar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}
