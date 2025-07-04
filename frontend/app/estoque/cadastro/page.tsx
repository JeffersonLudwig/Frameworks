import { Menu, Sidebar } from "@/components/menu";

export default function CadastroEstoque() {
  return (
    <div>
      <div className="flex overflow-hidden h-screen">
        <div className="h-screen">
          <Menu />
        </div>
        <div className="w-full">
          <Sidebar />
        </div>
      </div>
    </div>
  );
}
