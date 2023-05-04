<template>
  <div class="flex_horizontal">
    <button
      type="button"
      class='base_button button_primary invert'
      @click.prevent="saveInsertion"
    >
      Registrar
    </button>

    <button
      type="button"
      class='base_button button_danger invert'
      @click.prevent="cancelInsertion"
    >
      Cancelar
    </button>
    <button
      type="button"
      class='base_button button_danger'
      @click.prevent="deleteInsertion"
    >
      Deletar
    </button>
  </div>
</template>

<script>
export default {
  name: 'BaseEditButtons',
  methods: {
    saveInsertion() {
      this.$emit('saveEmit');
    },
    cancelInsertion() {
      this.$emit('cancelEmit');
    },
    deleteInsertion() {
      this.$emit('deleteEmit');
    },
  },
};
</script>
