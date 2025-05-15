"use client";
import { useState } from "react";

function InputPesquisa() {
  const [pesquisa, setPesquisa] = useState("");
  const handleChangePesquisa = (e: React.ChangeEvent<HTMLInputElement>) => {
    const texto = e.target.value;
    setPesquisa(texto);
  };

  return (
    <input
      type="text"
      placeholder="Digite aqui..."
      className="w-full border border-gray-300 rounded px-4 py-2 mb-4"
      value={pesquisa}
      onChange={handleChangePesquisa}
    />
  );
}

function InputQuantidade() {
  const [quantidade, setQuantidade] = useState("");
  const [unidade, setUnidade] = useState("UN");

  const handleChangeQuantidade = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;

    if (unidade === "UN") {
      if (/^\d*$/.test(value)) {
        setQuantidade(value);
      }
    } else {
      setQuantidade(value);
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

  return (
    <>
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
    </>
  );
}

function InputUnidade() {
  const [unidade, setUnidade] = useState("UN");
  const handleChangeUnidade = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const value = e.target.value;
    setUnidade(value);
  };
  return (
    <>
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
    </>
  );
}

function InputProduto() {
  const [produto, setProduto] = useState("");
  const handleChangeProduto = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = e.target.value;
    if (/^\d*$/.test(value)) {
      setProduto(value);
    }
  };

  return (
    <>
      <div className="flex flex-col">
        <input
          type="text"
          name="produto"
          id="produto"
          value={produto}
          onChange={handleChangeProduto}
          className="border rounded w-[15vw] p-3 text-lg"
        ></input>
      </div>
    </>
  );
}
export { InputPesquisa, InputQuantidade, InputUnidade, InputProduto };
