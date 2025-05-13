"use client";

import { Menu, Sidebar } from "@/components/menu";
import { useState } from "react";
import Implantacao from "./implantacao";

export default function Movimentacao() {
  const [tipo, setTipo] = useState("");

  const handleChange = (e: any) => {
    setTipo(e.target.value);
  };
  const renderizarComponente = () => {
    if (tipo === "implantacao") return <Implantacao />;
    // if (tipo === 'entrada') return <Entrada />;
    // if (tipo === 'saida') return <Saida />;
    return null;
  };
  return (
    <div>
      <div className="flex overflow-hidden">
        <div className="h-screen">
          <Menu />
        </div>
        <div className="w-full">
          <Sidebar />
          <div className="flex flex-col bg-white rounded-lg p-6">
            <h2 className="text-xl font-bold mb-4">Movimentação de Estoque</h2>
            <form className="flex flex-col gap-4">
              <select
                className="border p-2 rounded"
                value={tipo}
                onChange={handleChange}
              >
                <option value="implantacao">Implantação</option>
                <option value="entrada">Entrada Manual</option>
                <option value="saida">Saída Manual</option>
              </select>
              {renderizarComponente()}
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
    </div>
  );
}
