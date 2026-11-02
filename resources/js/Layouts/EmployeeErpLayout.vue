<template>
  <div class="min-h-screen bg-surface-canvas text-text-primary flex">
    <aside class="w-64 bg-surface-inverse text-white p-4 hidden md:block">
      <div class="font-bold mb-8">ERP System</div>
      <nav class="flex flex-col gap-4">
        <a href="#">Dashboard</a>
        <a href="#">LIMS Workbench</a>
        <a href="#">CRM & Leads</a>
        <a href="#">Projects</a>
      </nav>
    </aside>
    <main class="flex-1 p-8">
      <slot />
    </main>
  </div>
</template>
