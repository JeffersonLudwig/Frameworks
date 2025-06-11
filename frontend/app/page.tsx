"use client";

import type React from "react";

import { Button } from "@/components/ui/button";
import { useRouter } from "next/navigation";
import { useState } from "react";
import Image from "next/image";

export default function Home() {
  const router = useRouter();
  const [errors, setErrors] = useState<{ email?: string; senha?: string }>({});
  const [isLoading, setIsLoading] = useState(false);

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setIsLoading(true);
    setErrors({});

    const formData = new FormData(e.currentTarget);
    const email = formData.get("email") as string;
    const senha = formData.get("senha") as string;

    const newErrors: { email?: string; senha?: string } = {};

    if (!email || email.trim() === "") {
      newErrors.email = "Preencha o usuário!";
    }
    if (!senha || senha.trim() === "") {
      newErrors.senha = "Preencha a senha!";
    }

    if (Object.keys(newErrors).length > 0) {
      setErrors(newErrors);
      setIsLoading(false);
      return;
    }

    const fetchApiLogin = async () => {
      try {
        const response = await fetch("http://localhost:8080/api/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ email, senha }),
        });

        const data = await response.json();

        if (response.ok) {
          localStorage.setItem("token", data.token);
          router.push("/dashboard");
        } else {
          const errorMessage =
            data?.messages?.error ||
            data?.message ||
            "Erro ao fazer login. Verifique seus dados.";

          setErrors({ senha: errorMessage });
          setIsLoading(false);
        }
      } catch (error) {
        console.error("Erro ao fazer login:", error);
        setIsLoading(false);
      }
    };
    fetchApiLogin();
  }

  return (
    <div className="flex w-screen h-screen bg-[#363636]">
      <div className="w-[50vw] relative">
        <Image
          src="/logodashboard.png"
          fill
          object-fit="cover"
          alt="logo"
          className="w-full h-full"
        />
      </div>

      <div className="flex flex-col w-[50vw] h-full justify-center items-center px-8">
        <form
          onSubmit={handleSubmit}
          className="flex flex-col gap-6 w-full max-w-md"
        >
          <div className="w-full flex justify-center items-center mb-8">
            <h1 className="text-5xl text-center bg-gradient-to-b from-[#f6faf7] to-[#848D90] bg-clip-text text-transparent font-bold">
              AutoCenter
            </h1>
          </div>

          <div className="flex flex-col gap-2">
            <label htmlFor="email" className="text-white text-base font-medium">
              Usuário
            </label>
            <input
              type="text"
              id="email"
              name="email"
              placeholder="Digite seu usuário"
              className="p-3 rounded-md border border-gray-400 text-base text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              disabled={isLoading}
            />
            {errors.email && (
              <span className="text-red-400 text-sm">{errors.email}</span>
            )}
          </div>

          <div className="flex flex-col gap-2">
            <label htmlFor="senha" className="text-white text-base font-medium">
              Senha
            </label>
            <input
              type="password"
              id="senha"
              name="senha"
              placeholder="Digite sua senha"
              className="p-3 rounded-md border border-gray-400 text-base text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              disabled={isLoading}
            />
            {errors.senha && (
              <span className="text-red-400 text-sm">{errors.senha}</span>
            )}
          </div>

          <Button
            type="submit"
            className="mt-4 py-3 text-base font-medium"
            disabled={isLoading}
          >
            {isLoading ? "Entrando..." : "Entrar"}
          </Button>
        </form>
      </div>
    </div>
  );
}
