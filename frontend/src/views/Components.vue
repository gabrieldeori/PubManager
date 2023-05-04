<template>
  <section>
    <h1>Paletas</h1>
    <div class="dropdown">
      <button class="btn btn-secondary dropdown-toggle"
      type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Dropdown button
      </button>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
      </ul>
    </div>
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
