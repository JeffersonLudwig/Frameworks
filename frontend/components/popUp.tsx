import { useEffect, useState } from "react";

type PopUpPesquisaProps = {
  mostrar: boolean;
  onFechar: () => void;
};
function PopUpPesquisa({ mostrar, onFechar }: PopUpPesquisaProps) {
  const [resultados, setResultados] = useState([]);
  const [pesquisa, setPesquisa] = useState("");
  const [mostrarPopup, setMostrarPopup] = useState(false);
  const [error, setError] = useState("");

  const MenuPesquisa = () => {
    setPesquisa("");
    onFechar();
  };

  const handleChangePesquisa = (e: React.ChangeEvent<HTMLInputElement>) => {
    const texto = e.target.value;
    setPesquisa(texto);
  };

  useEffect(() => {
    const handleEsc = (e: any) => {
      if (e.key === "Escape") {
        MenuPesquisa();
      }
    };
    window.addEventListener("keydown", handleEsc);
    return () => window.removeEventListener("keydown", handleEsc);
  }, [mostrarPopup]);

  useEffect(() => {
    if (pesquisa === "") {
      setResultados([]);
      return;
    }

    const delayDebounce = setTimeout(() => {
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
    }, 500);
    return () => clearTimeout(delayDebounce);
  }, [pesquisa]);

  return (
    <>
      {mostrar && (
        <>
          <div
            className="fixed inset-0 bg-black opacity-50 z-40"
            onClick={onFechar}
          />
          <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div className="bg-white rounded-xl shadow-lg w-[40vw] p-4 h-[40vh] flex flex-col">
              <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-semibold">Pesquisar Produto</h2>
                <button
                  onClick={onFechar}
                  aria-label="Fechar"
                  className="text-gray-500 hover:text-black"
                >
                  ✖
                </button>
              </div>
              <input
                type="text"
                placeholder="Digite o nome do produto..."
                className="w-full border border-gray-300 rounded px-4 py-2 mb-4"
                value={pesquisa}
                onChange={handleChangePesquisa}
                autoFocus
              />
              <div className="mt-2 overflow-y-auto flex-grow">
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
    </>
  );
}

export { PopUpPesquisa };
