"use client";

import { Search } from "lucide-react";
import { use, useEffect, useState } from "react";

export default function Implantacao() {
  const [quantidade, setQuantidade] = useState("");
  const [produto, setProduto] = useState("");
  const [unidade, setUnidade] = useState("UN");
  const [mostrarPopup, setMostrarPopup] = useState(false);
  const [pesquisa, setPesquisa] = useState("");
  const [resultados, setResultados] = useState([]);

  const handleChangeProduto = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    if (/^\d*$/.test(value)) {
      setProduto(value);
    }
  };
  const MenuPesquisa = () => {
    setMostrarPopup(true);
  };

  const fecharPopup = () => {
    setMostrarPopup(false);
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
          <input
            type="text"
            name="produto"
            id="produto"
            value={produto}
            onChange={handleChangeProduto}
            className="border rounded w-[15vw] p-3 text-lg"
          ></input>
          <button
            className="bg-blue-500 text-white rounded p-4"
            onClick={MenuPesquisa}
          >
            <Search />
          </button>
        </div>
        <label htmlFor="unidade" className="text-xl font-semibold">
          Unidade:
        </label>
        <select
          name="unidade"
          id="unidade"
          value={unidade}
          onChange={handleChangeUnidade}
          className="border rounded w-[15vw] p-3 text-lg"
        >
          <option value="UN">UN</option>
          <option value="KG">KG</option>
          <option value="MT">MT</option>
          <option value="L">L</option>
        </select>
        <label htmlFor="quantidade" className="text-xl font-semibold">
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
          className="border rounded w-[15vw] p-3 text-lg"
        />
      </div>
      {mostrarPopup && (
        <>
          <div className="fixed inset-0 bg-black opacity-50 z-40" />
          <div className="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div className="bg-white rounded-xl shadow-lg w-[40vw] p-6 h-[40vh]">
              <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-semibold">Pesquisar</h2>
                <button
                  onClick={fecharPopup}
                  className="text-gray-500 hover:text-black"
                >
                  ✖
                </button>
              </div>
              <input
                type="text"
                placeholder="Digite aqui..."
                className="w-full border border-gray-300 rounded px-4 py-2 mb-4"
                value={pesquisa}
                onChange={handleChangePesquisa}
              />
              <div className="mt-4">
                {pesquisa !== "" && resultados.length === 0 ? (
                  <p className="text-gray-500">Nenhum resultado encontrado.</p>
                ) : (
                  <ul>
                    {resultados.map((item: any) => (
                      <li key={item.id} className="border p-2 rounded mb-2">
                        {item.nome}
                      </li>
                    ))}
                  </ul>
                )}
              </div>
            </div>
          </div>
        </>
      )}
    </div>
  );
}
