<script setup>
import Layout from '../../Layouts/PublicWebsiteLayout.vue';
</script>
<template>
  <Layout>
    <div class="container mx-auto p-12">
      <h1 class="text-3xl font-bold text-win-navy">Verify Certificate of Analysis</h1>
      <div class="bg-surface-card p-8 mt-8 border-2 border-win-navy shadow-solid-3d-navy max-w-lg">
        <label class="block font-bold mb-2">Certificate Number</label>
        <input type="text" class="border-2 border-border-crisp w-full p-2 mb-4" placeholder="COA-AU-2026-XXXXX">
        <button class="bg-win-blue text-white px-4 py-2 font-bold hover:bg-win-blue-active transition-colors duration-75">Verify</button>
      </div>
    </div>
  </Layout>
</template>
