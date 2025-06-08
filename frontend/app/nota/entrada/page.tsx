"use client";

import type React from "react";

import { Menu, Sidebar } from "@/components/menu";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover";
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import {
  Command,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
} from "@/components/ui/command";
import { CalendarIcon, Check, User } from "lucide-react";
import { useEffect, useState } from "react";
import { format } from "date-fns";
import { ptBR } from "date-fns/locale";
import { cn } from "@/lib/utils";

interface Cliente {
  id: number;
  nome: string;
  cpf: string;
}

export default function NotaEntrada() {
  const [numeroNotaFiscal, setNumeroNotaFiscal] = useState("");
  const [numeroSerie, setNumeroSerie] = useState("");
  const [numeroFolhas, setNumeroFolhas] = useState("");
  const [naturezaOperacao, setNaturezaOperacao] = useState("");
  const [dataEmissao, setDataEmissao] = useState<Date>();
  const [dataSaida, setDataSaida] = useState<Date>();
  const [valorTotal, setValorTotal] = useState("");
  const [valorDesconto, setValorDesconto] = useState("");
  const [clientes, setClientes] = useState<Cliente[]>([]);
  const [clienteSelecionado, setClienteSelecionado] = useState<Cliente | null>(
    null
  );
  const [openClienteDialog, setOpenClienteDialog] = useState(false);
  const [openDataEmissao, setOpenDataEmissao] = useState(false);
  const [openDataSaida, setOpenDataSaida] = useState(false);
  const [horaEmissao, setHoraEmissao] = useState("");
  const [horaSaida, setHoraSaida] = useState("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    const dataEmissaoCompleta =
      dataEmissao && horaEmissao
        ? `${format(dataEmissao, "yyyy-MM-dd")} ${horaEmissao}:00`
        : null;

    const dataSaidaCompleta =
      dataSaida && horaSaida
        ? `${format(dataSaida, "yyyy-MM-dd")} ${horaSaida}:00`
        : null;

    const formData = {
      numero_nf: numeroNotaFiscal,
      numero_serie: numeroSerie,
      numero_folhas: numeroFolhas,
      natureza_operacao: naturezaOperacao,
      data_emissao: dataEmissaoCompleta,
      data_saida: dataSaidaCompleta,
      valor_total: Number.parseFloat(valorTotal),
      valor_desconto: Number.parseFloat(valorDesconto),
      cliente_id: clienteSelecionado?.id,
    };
    postApi(formData);
  };

  const postApi = async (formData: any) => {
    const response = await fetch("/api/nota/entrada", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(formData),
    });
    const data = await response.json();
    console.log(data);
  };

  const fatchApiClientes = async () => {
    try {
      const response = await fetch("/api/clientes");
      const data = await response.json();
      setClientes(data);
    } catch (error) {
      console.error("Erro ao buscar clientes:", error);
    }
  };

  useEffect(() => {
    fatchApiClientes();
  }, []);

  return (
    <div className="flex">
      <div className="h-screen">
        <Menu />
      </div>
      <div className="w-full">
        <Sidebar />
        <div className="w-full h-full p-5">
          <div className="max-w-4xl mx-auto">
            <h1 className="text-2xl font-bold mb-6">
              Cadastro de Nota Fiscal de Entrada
            </h1>

            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div className="space-y-2">
                  <Label
                    htmlFor="numerodanota"
                    className="text-base font-semibold"
                  >
                    Número da nota fiscal:
                  </Label>
                  <Input
                    id="numerodanota"
                    className="text-black"
                    placeholder="Número da nota fiscal"
                    value={numeroNotaFiscal}
                    onChange={(e) => setNumeroNotaFiscal(e.target.value)}
                    required
                  />
                </div>

                <div className="space-y-2">
                  <Label
                    htmlFor="numeroserie"
                    className="text-base font-semibold"
                  >
                    Número da série:
                  </Label>
                  <Input
                    id="numeroserie"
                    className="text-black"
                    placeholder="Número da série"
                    value={numeroSerie}
                    onChange={(e) => setNumeroSerie(e.target.value)}
                    required
                  />
                </div>

                <div className="space-y-2">
                  <Label
                    htmlFor="numerofolhas"
                    className="text-base font-semibold"
                  >
                    Número de folhas:
                  </Label>
                  <Input
                    id="numerofolhas"
                    className="text-black"
                    placeholder="Número de folhas"
                    value={numeroFolhas}
                    onChange={(e) => setNumeroFolhas(e.target.value)}
                    required
                  />
                </div>

                <div className="space-y-2 md:col-span-2">
                  <Label
                    htmlFor="naturezaoperacao"
                    className="text-base font-semibold"
                  >
                    Natureza da operação:
                  </Label>
                  <Input
                    id="naturezaoperacao"
                    className="text-black"
                    placeholder="Natureza da operação"
                    value={naturezaOperacao}
                    onChange={(e) => setNaturezaOperacao(e.target.value)}
                    required
                  />
                </div>

                <div className="space-y-2">
                  <Label className="text-base font-semibold">Cliente:</Label>
                  <Dialog
                    open={openClienteDialog}
                    onOpenChange={setOpenClienteDialog}
                  >
                    <DialogTrigger asChild>
                      <Button
                        variant="outline"
                        className="w-full justify-between text-black"
                      >
                        {clienteSelecionado ? (
                          <span>{clienteSelecionado.nome}</span>
                        ) : (
                          <span className="text-muted-foreground">
                            Selecionar cliente
                          </span>
                        )}
                        <User className="ml-2 h-4 w-4" />
                      </Button>
                    </DialogTrigger>
                    <DialogContent className="sm:max-w-[425px]">
                      <DialogHeader>
                        <DialogTitle>Selecionar Cliente</DialogTitle>
                      </DialogHeader>
                      <Command>
                        <CommandInput placeholder="Buscar cliente..." />
                        <CommandList>
                          <CommandEmpty>
                            Nenhum cliente encontrado.
                          </CommandEmpty>
                          <CommandGroup>
                            {clientes.map((cliente) => (
                              <CommandItem
                                key={cliente.id}
                                value={cliente.nome}
                                onSelect={() => {
                                  setClienteSelecionado(cliente);
                                  setOpenClienteDialog(false);
                                }}
                              >
                                <Check
                                  className={cn(
                                    "mr-2 h-4 w-4",
                                    clienteSelecionado?.id === cliente.id
                                      ? "opacity-100"
                                      : "opacity-0"
                                  )}
                                />
                                <div>
                                  <div className="font-medium">
                                    {cliente.nome}
                                  </div>
                                  <div className="text-sm text-muted-foreground">
                                    CPF: {cliente.cpf}
                                  </div>
                                </div>
                              </CommandItem>
                            ))}
                          </CommandGroup>
                        </CommandList>
                      </Command>
                    </DialogContent>
                  </Dialog>
                </div>

                <div className="space-y-2 md:col-span-2">
                  <Label className="text-base font-semibold">
                    Data e hora de emissão:
                  </Label>
                  <div className="flex gap-2">
                    <div className="flex-1">
                      <Popover
                        open={openDataEmissao}
                        onOpenChange={setOpenDataEmissao}
                      >
                        <PopoverTrigger asChild>
                          <Button
                            variant="outline"
                            className={cn(
                              "w-full justify-start text-left font-normal text-black",
                              !dataEmissao && "text-muted-foreground"
                            )}
                          >
                            <CalendarIcon className="mr-2 h-4 w-4" />
                            {dataEmissao ? (
                              format(dataEmissao, "PPP", { locale: ptBR })
                            ) : (
                              <span>Selecionar data</span>
                            )}
                          </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-auto p-0">
                          <Calendar
                            mode="single"
                            selected={dataEmissao}
                            onSelect={(date) => {
                              setDataEmissao(date);
                              setOpenDataEmissao(false);
                            }}
                          />
                        </PopoverContent>
                      </Popover>
                    </div>
                    <div className="w-auto">
                      <Input
                        type="time"
                        className="text-black"
                        value={horaEmissao}
                        onChange={(e) => setHoraEmissao(e.target.value)}
                        required
                      />
                    </div>
                  </div>
                </div>

                <div className="space-y-2 md:col-span-2">
                  <Label className="text-base font-semibold">
                    Data e hora de saída:
                  </Label>
                  <div className="flex gap-2">
                    <div className="flex-1">
                      <Popover
                        open={openDataSaida}
                        onOpenChange={setOpenDataSaida}
                      >
                        <PopoverTrigger asChild>
                          <Button
                            variant="outline"
                            className={cn(
                              "w-full justify-start text-left font-normal text-black",
                              !dataSaida && "text-muted-foreground"
                            )}
                          >
                            <CalendarIcon className="mr-2 h-4 w-4" />
                            {dataSaida ? (
                              format(dataSaida, "PPP", { locale: ptBR })
                            ) : (
                              <span>Selecionar data</span>
                            )}
                          </Button>
                        </PopoverTrigger>
                        <PopoverContent className="w-auto p-0">
                          <Calendar
                            mode="single"
                            selected={dataSaida}
                            onSelect={(date) => {
                              setDataSaida(date);
                              setOpenDataSaida(false);
                            }}
                          />
                        </PopoverContent>
                      </Popover>
                    </div>
                    <div className="w-auto">
                      <Input
                        type="time"
                        className="text-black"
                        value={horaSaida}
                        onChange={(e) => setHoraSaida(e.target.value)}
                        required
                      />
                    </div>
                  </div>
                </div>
                <div className="flex flex-col md:col-span-2">
                  <div className="space-y-2">
                    <Label
                      htmlFor="valortotal"
                      className="text-base font-semibold"
                    >
                      Valor total:
                    </Label>
                    <Input
                      id="valortotal"
                      type="number"
                      step="0.01"
                      className="text-black"
                      placeholder="0,00"
                      value={valorTotal}
                      onChange={(e) => setValorTotal(e.target.value)}
                      required
                    />
                  </div>
                  <div className="space-y-2">
                    <Label
                      htmlFor="valordesconto"
                      className="text-base font-semibold"
                    >
                      Valor desconto:
                    </Label>
                    <Input
                      id="valordesconto"
                      type="number"
                      step="0.01"
                      className="text-black"
                      placeholder="0,00"
                      value={valorDesconto}
                      onChange={(e) => setValorDesconto(e.target.value)}
                    />
                  </div>
                </div>
              </div>
              {/* Botões de Ação */}
              <div className="flex gap-4 pt-6">
                <Button type="submit" className="px-8">
                  Salvar Nota Fiscal
                </Button>
                <Button type="button" variant="outline" className="px-8">
                  Cancelar
                </Button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
}
