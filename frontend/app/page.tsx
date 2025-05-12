"use client";

import { Button } from "@/components/ui/button";
import { redirect } from "next/navigation";
import Image from "next/image";
import Link from "next/link";

export default function Home() {
  function handleSubmit(e: any) {
    e.preventDefault();
    const usuario = e.target.usuario.value;
    const senha = e.target.senha.value;

    // if (!usuario) {
    //   alert("Preencha o usuário!");
    //   return;
    // }
    // if (!senha) {
    //   alert("Preencha a senha!");
    //   return;
    // }

    redirect("/dashboard");
  }
  return (
    <div className="flex w-screen h-screen bg-[#363636]">
      <div className="">
        <Image
          src="/logo.png"
          width={1000}
          height={100}
          object-fit="cover"
          alt="logo"
          className="w-[50vw] h-full"
        />
      </div>
      <form
        onSubmit={handleSubmit}
        className="flex flex-col w-[50vw] h-full justify-center items-center gap-3"
      >
        <div className="flex flex-col text-white gap-3">
          <div className="w-full h-full flex justify-center items-center">
            <h1 className="text-5xl text-center bg-gradient-to-b from-[#f6faf7] to-[#848D90] bg-clip-text text-transparent font-bold">
              AutoCenter
            </h1>
          </div>
          <div className="flex flex-col">
            <label htmlFor="usuario" className="text-base">
              Usuário
            </label>
            <input
              type="usuario"
              id="usuario"
              name="usuario"
              placeholder="Usuário"
              // required
              className="p-1 rounded-md border-[1px] border-gray-400 text-base"
            />
          </div>
          <div className="flex flex-col">
            <label htmlFor="senha" className="text-base">
              Senha
            </label>
            <input
              type="password"
              id="senha"
              name="senha"
              placeholder="Senha"
              // required
              className="p-1 rounded-md border-[1px] border-gray-400 text-base"
            />
          </div>
        </div>
        <Button type="submit">Entrar</Button>
      </form>
    </div>
  );
}
