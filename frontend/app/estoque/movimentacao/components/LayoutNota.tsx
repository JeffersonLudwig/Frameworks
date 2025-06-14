"use client";

import { PopUpPesquisa } from "@/components/popUp";
import { Search } from "lucide-react";
import { useEffect, useState } from "react";

export default function LayoutNota() {
  const [quantidade, setQuantidade] = useState("");
  const [produto, setProduto] = useState("");
  const [unidade, setUnidade] = useState("UN");
  const [mostrarPopup, setMostrarPopup] = useState(false);
  const [pesquisa, setPesquisa] = useState("");
  const [resultados, setResultados] = useState([]);
  const [numeroNota, setNumeroNota] = useState("");
  const [erro, setErro] = useState(false);

  const abrirPopup = () => setMostrarPopup(true);
  const fecharPopup = () => setMostrarPopup(false);

  const handleChangeProduto = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    if (/^\d*$/.test(value)) {
      setProduto(value);
    }
  };

  const handleChangeNumeroNota = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    if (/^\d*$/.test(value)) {
      setNumeroNota(value);
    }
  };
  const MenuPesquisa = () => {
    setMostrarPopup((prev) => !prev);
    setPesquisa("");
  };

  const handleChangeUnidade = (e: any) => {
    const value = e.target.value;
    setUnidade(value);
  };
  const handleChangeQuantidade = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;

    if (unidade === "UN") {
      if (/^\d*$/.test(value)) {
        setQuantidade(value);
      }
      return;
    }

    if (unidade === "KG" || unidade === "MT") {
      if (/^\d*\.?\d*$/.test(value)) {
        const parts = value.split(".");
        if (parts.length === 2 && parts[1].length >= 2) {
          const parsed = parseFloat(value);
          if (!isNaN(parsed)) {
            setQuantidade(parsed.toFixed(2));
            return;
          }
        }
        setQuantidade(value);
      }
    }
  };

  const handleBlurQuantidade = () => {
    if (quantidade !== "") {
      const parsed = parseFloat(quantidade);
      if (!isNaN(parsed)) {
        setQuantidade(parsed.toFixed(2));
      }
    }
  };

  const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
  };

  const handleChangePesquisa = (e: React.ChangeEvent<HTMLInputElement>) => {
    const texto = e.target.value;
    setPesquisa(texto);
  };

  useEffect(() => {
    if (pesquisa === "") {
      setResultados([]);
      return;
    }

    const buscar = async () => {
      try {
        const res = await fetch(`/api/produtos?query=${pesquisa}`);
        const data = await res.json();
        setResultados(data);
      } catch (error) {
        console.error("Erro na busca:", error);
      }
    };

    buscar();
  }, [pesquisa]);

  useEffect(() => {
    const handleEsc = (e: any) => {
      if (e.key === "Escape") {
        MenuPesquisa();
      }
    };
    window.addEventListener("keydown", handleEsc);
    return () => window.removeEventListener("keydown", handleEsc);
  }, [mostrarPopup]);
  return (
    <div className=" bg-white text-black">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
        <div className="flex flex-col space-y-2">
          <label htmlFor="estoque" className="text-lg md:text-xl font-semibold">
            Estoque:
          </label>
          <select
            name="estoque"
            id="estoque"
            className="border rounded w-full p-2 md:p-3 text-base md:text-lg"
          >
            <option value="1">Estoque 1</option>
            <option value="2">Estoque 2</option>
            <option value="3">Estoque 3</option>
          </select>
        </div>

        <div className="flex flex-col space-y-2">
          <label htmlFor="produto" className="text-lg md:text-xl font-semibold">
            Produto:
          </label>
          <div className="flex items-center gap-2">
            <input
              type="text"
              name="produto"
              id="produto"
              value={produto}
              onChange={handleChangeProduto}
              className="border rounded w-full p-2 md:p-3 text-base md:text-lg"
            />
            <button
              className="bg-blue-500 text-white rounded p-2 md:p-3 flex items-center justify-center"
              onClick={MenuPesquisa}
              aria-label="Pesquisar produto"
            >
              <Search className="h-5 w-5" />
            </button>
          </div>
        </div>

        <div className="flex flex-col space-y-2">
          <label htmlFor="unidade" className="text-lg md:text-xl font-semibold">
            Unidade:
          </label>
          <select
            name="unidade"
            id="unidade"
            value={unidade}
            onChange={handleChangeUnidade}
            className="border rounded w-full p-2 md:p-3 text-base md:text-lg"
          >
            <option value="UN">UN</option>
            <option value="KG">KG</option>
            <option value="MT">MT</option>
            <option value="L">L</option>
          </select>
        </div>

        <div className="flex flex-col space-y-2">
          <label
            htmlFor="quantidade"
            className="text-lg md:text-xl font-semibold"
          >
            Quantidade:
          </label>
          <input
            type="text"
            name="quantidade"
            id="quantidade"
            value={quantidade}
            onBlur={handleBlurQuantidade}
            onChange={handleChangeQuantidade}
            placeholder="Quantidade"
            className="border rounded w-full p-2 md:p-3 text-base md:text-lg"
          />
        </div>

        <div className="flex flex-col space-y-2">
          <label
            htmlFor="numeroNota"
            className="text-lg md:text-xl font-semibold"
          >
            Número da Nota:
          </label>
          <input
            type="text"
            name="numeroNota"
            id="numeroNota"
            value={numeroNota}
            onChange={handleChangeNumeroNota}
            className="border rounded w-full p-2 md:p-3 text-base md:text-lg"
          />
        </div>

        <div className="flex flex-col space-y-2">
          <label
            htmlFor="observacao"
            className="text-lg md:text-xl font-semibold"
          >
            Observação:
          </label>
          <textarea
            name="observacao"
            id="observacao"
            className="border rounded w-full p-2 md:p-3 text-base md:text-lg min-h-[100px]"
          />
        </div>
      </div>

      <PopUpPesquisa mostrar={mostrarPopup} onFechar={fecharPopup} />
    </div>
  );
}
