<template>
  <div class="palette_view">
    Palette
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
  align-items: center;
  padding: 20px;
  gap: 10px;

  width: 1068px;
  height: 999px;

  background: #FFF3ED;

  flex: none;
  order: 0;
  flex-grow: 0;
}
</style>
