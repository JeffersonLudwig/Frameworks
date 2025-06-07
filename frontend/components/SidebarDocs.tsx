"use client";
import { useState } from "react";
import { useRouter, usePathname } from "next/navigation";
import { Button } from "@/components/ui/button";
import { ChevronDown, FileText } from "lucide-react";
import clsx from "clsx";

type MenuItem = {
  key: string;
  label: string;
  path?: string; // Caminho para navegação
  children?: MenuItem[];
};

const menuItems: MenuItem[] = [
  {
    key: "estoque",
    label: "Estoque",
    children: [
      {
        key: "funcoesEstoque",
        label: "Funções",
        children: [
          {
            key: "cadastrarNotaFiscal",
            label: "cadastrarNotaFiscal",
            path: "/docs/estoque/funcoes/cadastrar-nota-fiscal",
          },
          {
            key: "listarNotaFiscal",
            label: "listarNotaFiscal",
            path: "/docs/estoque/funcoes/listar-nota-fiscal",
          },
          {
            key: "listarNotaFiscalId",
            label: "listarNotaFiscalId",
            path: "/docs/estoque/funcoes/listar-nota-fiscal-id",
          },
        ],
      },
    ],
  },
  {
    key: "fiscal",
    label: "Fiscal",
    children: [
      {
        key: "functionsFiscal",
        label: "Functions",
        children: [
          {
            key: "listarNotaFiscalFiscal",
            label: "listarNotaFiscal",
            path: "/docs/fiscal/functions/listar-nota-fiscal",
          },
        ],
      },
      {
        key: "dtoFiscal",
        label: "DTO",
        children: [
          {
            key: "NotaFiscalRequestDTO",
            label: "NotaFiscalRequestDTO",
            path: "/docs/fiscal/dto/nota-fiscal-request",
          },
          {
            key: "NotaFiscalResponseDTO",
            label: "NotaFiscalResponseDTO",
            path: "/docs/fiscal/dto/nota-fiscal-response",
          },
        ],
      },
      {
        key: "modelsFiscal",
        label: "Models",
        children: [
          {
            key: "NotaFiscalModel",
            label: "NotaFiscalModel",
            path: "/docs/fiscal/models/nota-fiscal-model",
          },
        ],
      },
    ],
  },
];

export default function SidebarDocs() {
  const [openMenus, setOpenMenus] = useState<{ [key: string]: boolean }>({});
  const router = useRouter();
  const pathname = usePathname();

  const toggleMenu = (key: string) => {
    setOpenMenus((prev) => {
      const currentState = prev[key] || false;
      return {
        ...prev,
        [key]: !currentState,
      };
    });
  };

  const handleNavigation = (path: string) => {
    router.push(path);
  };

  const isActivePath = (path: string) => {
    return pathname === path;
  };

  const renderMenu = (items: MenuItem[], depth = 0) => {
    return items.map((item) => {
      const isOpen = openMenus[item.key] || false;
      const hasChildren = !!item.children?.length;
      const isLeaf = !hasChildren && !!item.path;
      const isActive = item.path ? isActivePath(item.path) : false;

      return (
        <div key={item.key} className="w-full">
          <Button
            onClick={() => {
              if (hasChildren) {
                toggleMenu(item.key);
              } else if (item.path) {
                handleNavigation(item.path);
              }
            }}
            className={clsx(
              "flex items-center justify-between w-full text-left text-gray-200 hover:bg-[#0F1419]  transition-colors duration-200",
              depth > 0 && "ml-4",
              isActive && "bg-[#1A4B3A]  hover:bg-[#1F5640] hover:text-white",
              !hasChildren && !isLeaf && "cursor-default"
            )}
            variant={isActive ? "default" : "ghost"}
          >
            <div className="flex items-center">
              {hasChildren && (
                <ChevronDown
                  className={clsx(
                    "mr-2 h-4 w-4 transition-transform duration-200",
                    isOpen && "rotate-180"
                  )}
                />
              )}
              {isLeaf && <FileText className="mr-2 h-4 w-4" />}
              <span className="truncate">{item.label}</span>
            </div>
          </Button>

          {hasChildren && isOpen && item.children && (
            <div className="ml-2 mt-1 space-y-1">
              {renderMenu(item.children, depth + 1)}
            </div>
          )}
        </div>
      );
    });
  };

  return (
    <div className="h-min-screen w-[300px] bg-[#080A13] flex flex-col mt-10">
      <div className="p-4 bg-[#0A0D16]">
        <h1 className="text-xl font-bold text-gray-100">Documentação</h1>
      </div>
      <div className="flex-1 overflow-hidden p-2">
        <div className="space-y-1">{renderMenu(menuItems)}</div>
      </div>
    </div>
  );
}
