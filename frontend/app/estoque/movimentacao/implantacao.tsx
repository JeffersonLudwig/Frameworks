"use client";

import {
  InputProduto,
  InputQuantidade,
  InputUnidade,
} from "@/components/inputs";
import { PopUpPesquisa } from "@/components/popUp";
import { Search } from "lucide-react";
import { use, useEffect, useState } from "react";

export default function Implantacao() {
  const [produto, setProduto] = useState("");
  const [mostrarPopup, setMostrarPopup] = useState(false);
  const abrirPopup = () => setMostrarPopup(true);
  const fecharPopup = () => setMostrarPopup(false);

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
  };

  return (
    <div>
      <div className="flex flex-col">
        <label htmlFor="estoque" className="text-xl font-semibold">
          Estoque:
        </label>
        <select
          name="estoque"
          id="estoque"
          className="border rounded w-[15vw] p-3 text-lg"
        >
          <option value="1">Estoque 1</option>
          <option value="2">Estoque 2</option>
          <option value="3">Estoque 3</option>
        </select>
      </div>
      <div className="flex flex-col">
        <label htmlFor="produto" className="text-xl font-semibold">
          Produto:
        </label>
        <div className="flex items-center gap-2">
          <InputProduto />
          <button
            className="bg-blue-500 text-white rounded p-4"
            onClick={abrirPopup}
          >
            <Search />
          </button>
        </div>
        <InputUnidade />
        <InputQuantidade />
      </div>
      <PopUpPesquisa mostrar={mostrarPopup} onFechar={fecharPopup} />
    </div>
  );
}
