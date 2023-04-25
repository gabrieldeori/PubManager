<template>
  <form>
    <h1>FORM</h1>
    <BaseInput
      v-model="name"
      label="Nome"
      type="text"
      placeholder="Apenas letras e espaços"
      required
    />
    <button class="base_button button_primary">
      Registrar Cliente
    </button>
  </form>
</template>

<script>
export default {
  name: 'ClientRegister',
  data() {
    return {
      name: '',
    };
  },
};
</script>
