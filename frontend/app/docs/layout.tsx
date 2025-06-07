import SidebarDocs from "@/components/SidebarDocs";

export default function DocsLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <div className="flex w-screen bg-[#080A13] overflow-hidden">
      <SidebarDocs />
      <main className="flex-1 p-8 overflow-hidden">{children}</main>
    </div>
  );
}
