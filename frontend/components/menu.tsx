"use client";

import { ChevronDown, LogOut, User } from "lucide-react";
import { MenuEstoque } from "./menuEstoque";
import MenuFiscal from "./menuFiscal";
import Image from "next/image";
import { useEffect, useState } from "react";
import Perfil from "../app/perfil/page";
import { redirect } from "next/navigation";
function MenuHumburguer() {
  return (
    <div>
      <div className="">Menu</div>
    </div>
  );
}

function Menu() {
  return (
    <div className="w-[250px] h-full bg-[#363636] text-white">
      <div className="">
        <Image
          src="/logodashboard.png"
          width={1000}
          height={100}
          object-fit="cover"
          alt="logo"
          className="w-[13vw] h-[90px]"
        />
      </div>
      <div className="flex flex-col gap-2 ml-2">
        <MenuFiscal />
        <MenuEstoque />
      </div>
    </div>
  );
}

function Sidebar() {
  const [open, setOpen] = useState(false);
  function openMenu() {
    setOpen(!open);
  }
  return (
    <div className="w-full h-[70px] bg-[#363636]">
      <div className="w-full h-full flex items-center justify-end">
        <div className="flex items-center gap-2 mr-2">
          <div className="flex w-[50px] h-[50px] bg-gradient-to-r from-[#b42525] to-[#1c4aa1] rounded-full">
            <Image
              src="/logo.png"
              width={1000}
              height={100}
              object-fit="cover"
              alt="logo"
              className="w-full h-full rounded-full p-[2px]"
            />
          </div>

          <div className="relative">
            <button onClick={openMenu}>
              <ChevronDown />
            </button>
            {open && (
              <div className="w-[20vh] h-[10vh] bg-[#363636] text-white fixed top-[70px] right-0 z-50">
                <MenuDropDown />
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}

function MenuDropDown() {
  function redirectPerfil() {
    redirect("/perfil");
  }

  return (
    <div className="w-full h-full">
      <ul>
        <li>
          <button onClick={redirectPerfil} className="flex gap-2">
            <User /> Perfil
          </button>
        </li>
        <li>
          <button onClick={redirectPerfil} className="flex gap-2">
            <LogOut /> Sair
          </button>
        </li>
      </ul>
    </div>
  );
}
export { MenuHumburguer, Menu, Sidebar };
