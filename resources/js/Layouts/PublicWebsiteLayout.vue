<template>
  <div class="min-h-screen bg-surface-canvas text-text-primary" :dir="$page.props.dir || 'ltr'">
    <header class="bg-win-navy text-white">
      <div class="container mx-auto px-4 py-2 flex justify-between items-center text-sm">
        <div>Live Spot Gold: $2640/oz</div>
        <div class="flex gap-4">
          <span class="bg-win-green px-2 rounded font-bold">WhatsApp Us</span>
          <span>EN | SO | AR</span>
        </div>
      </div>
      <nav class="bg-surface-card text-text-primary border-b-4 border-win-gold">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
          <div class="font-bold text-xl uppercase tracking-wider text-win-navy">Gold & Mineral Co.</div>
          <div class="hidden md:flex gap-6 font-semibold">
            <a href="/">Home</a>
            <a href="/services">Services</a>
            <a href="/laboratory">Laboratory</a>
            <a href="/verify-certificate">Verify CoA</a>
          </div>
        </div>
      </nav>
    </header>
    <main>
      <slot />
    </main>
    <footer class="bg-surface-inverse text-surface-canvas p-8 mt-12">
      <div class="container mx-auto">
        &copy; 2026 Gold & Mineral Mining Consultation. ISO/IEC 17025 Compliant.
      </div>
    </footer>
  </div>
</template>
