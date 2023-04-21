<template>
  <h1>Paletas</h1>
  <div class="palette_view">
    <PaletteComponent />
  </div>
</template>

<script>
import PaletteComponent from '@/components/design/PaletteComponent.vue';

export default {
  name: 'PaletteView',
  components: {
    PaletteComponent,
  },
};
</script>

<style scoped>
.palette_view {
  display: flex;
  flex-flow: row wrap;
  justify-content: center;
  background: var(--smooth_white);
}
</style>
