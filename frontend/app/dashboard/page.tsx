import { Menu, Sidebar } from "@/components/menu";

export default function Dashboard() {
  return (
    <div className="flex">
      <div className="h-screen">
        <Menu />
      </div>
      <div className="w-full">
        <Sidebar />
      </div>
    </div>
  );
}
