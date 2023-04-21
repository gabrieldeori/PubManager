<template>
  <div class="palette_component">
    Palette 21215215
    <ColorComponent />
    <ColorComponent />
    <ColorComponent />
    <ColorComponent />
    <ColorComponent />
  </div>
</template>

<script>
import ColorComponent from '@/components/design/ColorComponent.vue';

export default {
  name: 'PaletteComponent',
  components: {
    ColorComponent,
  },
};
</script>

<style scoped>
.palette_component {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 0px;
  gap: 14px;

  width: 228px;
  height: 959px;

  flex: none;
  order: 0;
  flex-grow: 0;
}
</style>
