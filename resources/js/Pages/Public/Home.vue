<script setup>
import Layout from '../../Layouts/PublicWebsiteLayout.vue';
</script>
<template>
  <Layout>
    <section class="bg-surface-canvas p-12">
      <div class="container mx-auto">
        <h1 class="text-4xl font-bold text-win-navy mb-4">Precision Gold Assaying & Mining Consultation</h1>
        <p class="text-lg text-text-secondary">Explore our ISO/IEC 17025 compliant services.</p>
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="bg-surface-card p-6 shadow-solid-3d-navy rounded-3d-curve border-2 border-border-3d-extrude">
            <h2 class="text-2xl font-bold text-win-blue">Gold & Mineral Laboratory</h2>
            <p class="mt-2 text-text-secondary">Order tests online and track your assay results in real-time.</p>
          </div>
          <div class="bg-surface-card p-6 shadow-solid-3d-gold rounded-3d-curve border-2 border-border-3d-extrude">
            <h2 class="text-2xl font-bold text-win-gold">Exploration Consultation</h2>
            <p class="mt-2 text-text-secondary">Comprehensive field services and technical reporting.</p>
          </div>
        </div>
      </div>
    </section>
  </Layout>
</template>
