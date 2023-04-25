<template>
  <h1>Paletas</h1>
  <div class="components_view">
    <PaletteComponent />
    <ButtonsComponent />
    <SimpleForm />
  </div>
</template>

<script>
import PaletteComponent from '@/components/design/PaletteComponent.vue';
import ButtonsComponent from '@/components/buttons/ButtonsComponent.vue';
import SimpleForm from '@/components/forms/SimpleForm.vue';

export default {
  name: 'ComponentsView',
  components: {
    PaletteComponent,
    ButtonsComponent,
    SimpleForm,
  },
};
</script>

<style scoped>
.components_view {
  align-items: center;
  display: flex;
  flex-flow: column;
  gap: 2rem;
}
</style>
