"use client";

import {
  InputProduto,
  InputQuantidade,
  InputUnidade,
} from "@/components/inputs";
import { PopUpPesquisa } from "@/components/popUp";
import { Search } from "lucide-react";
import { useImperativeHandle, useRef, useState, forwardRef } from "react";

export type ImplantacaoHandles = {
  getDados: () => {
    produto: string;
    unidade: string;
    quantidade: number;
  };
};

const Implantacao = forwardRef<ImplantacaoHandles>((_, ref) => {
  const produtoRef = useRef<any>(null);
  const unidadeRef = useRef<any>(null);
  const quantidadeRef = useRef<any>(null);

  const [mostrarPopup, setMostrarPopup] = useState(false);

  const abrirPopup = () => setMostrarPopup(true);
  const fecharPopup = () => setMostrarPopup(false);

  useImperativeHandle(ref, () => ({
    getDados: () => ({
      produto: produtoRef.current?.getProduto(),
      unidade: unidadeRef.current?.getUnidade(),
      quantidade: quantidadeRef.current?.getQuantidade(),
    }),
  }));

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

      <div className="flex flex-col mt-4">
        <label htmlFor="produto" className="text-xl font-semibold">
          Produto:
        </label>
        <div className="flex items-center gap-2">
          <InputProduto ref={produtoRef} />
          <button
            type="button"
            className="bg-blue-500 text-white rounded p-4"
            onClick={abrirPopup}
          >
            <Search />
          </button>
        </div>

        <InputUnidade ref={unidadeRef} />
        <InputQuantidade ref={quantidadeRef} />
      </div>

      <PopUpPesquisa mostrar={mostrarPopup} onFechar={fecharPopup} />
    </div>
  );
});

export default Implantacao;
