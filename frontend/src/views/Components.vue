<template>
  <section>
    <h1>Paletas</h1>
      <PaletteComponent />
      <ButtonsComponent />
      <SimpleForm />
  </section>
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
