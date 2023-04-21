<template>
  <h1>Paletas</h1>
  <div class="components_view">
    <PaletteComponent />
    <ButtonsComponent />
  </div>
</template>

<script>
import PaletteComponent from '@/components/design/PaletteComponent.vue';
import ButtonsComponent from '@/components/buttons/ButtonsComponent.vue';

export default {
  name: 'ComponentsView',
  components: {
    PaletteComponent,
    ButtonsComponent,
  },
};
</script>

<style scoped>
.components_view {
  display: flex;
  flex-flow: column;
  align-items: center;
  background: var(--smooth_white);
  gap: 2rem
}
</style>
