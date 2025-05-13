import Link from "next/link";

export function MenuEstoque() {
  return (
    <div className="">
      <h1 className="text-sm font-bold">Estoque</h1>
      <ul className="ml-5">
        <Link href="/estoque/movimentacao">
          <li>Movimentação</li>
        </Link>
        <Link href="/estoque/cadastro">Cadastro de Estoque</Link>
      </ul>
    </div>
  );
}
