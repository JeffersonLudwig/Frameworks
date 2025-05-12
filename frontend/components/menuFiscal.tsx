import Link from "next/link";

export default function MenuFiscal() {
  return (
    <div className="">
      <h1 className="text-sm font-bold">Fiscal</h1>
      <ul className="ml-5">
        <Link href="/nota/entrada">
          <li>Entrada de Nota Fiscal</li>
        </Link>
        <Link href="/nota/saida">
          <li>Saída de Nota Fiscal</li>
        </Link>
      </ul>
    </div>
  );
}
