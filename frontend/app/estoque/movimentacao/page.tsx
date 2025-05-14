"use client";

import { Menu, Sidebar } from "@/components/menu";
import { useState } from "react";
import Implantacao from "./implantacao";
import Entrada from "./entrada";

export default function Movimentacao() {
  const [tipo, setTipo] = useState("implantacao");

  const handleChange = (e: any) => {
    setTipo(e.target.value);
  };
  const renderizarComponente = () => {
    if (tipo === "implantacao") return <Implantacao />;
    if (tipo === "entrada") return <Entrada />;
    // if (tipo === 'saida') return <Saida />;
    return null;
  };

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
  };

  return (
    <div>
      <div className="flex overflow-hidden">
        <div className="h-screen">
          <Menu />
        </div>
        <div className="w-full">
          <Sidebar />
          <div className="flex flex-col w-full h-[94.3vh] bg-white p-6 gap-5">
            <div className="flex w-full h-[5vh] items-center">
              <h2 className="text-3xl font-bold">Movimentação de Estoque</h2>
            </div>
            <form className="flex flex-col gap-4 ml-10" onSubmit={handleSubmit}>
              <select
                className="border rounded w-[15vw] p-3 text-xl"
                value={tipo}
                onChange={handleChange}
              >
                <option value="implantacao">Implantação</option>
                <option value="entrada">Entrada Manual</option>
                <option value="saida">Saída Manual</option>
              </select>
              {renderizarComponente()}
              <div className="flex justify-between gap-2 mt-4 w-[15vw]">
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
