<template>
  <div class="flex_horizontal">
    <button
      class='base_button button_primary invert'
      @click="saveInsertion"
    >
      Registrar
    </button>

    <button
      class='base_button button_danger invert'
      @click="cancelInsertion"
    >
      Cancelar
    </button>
    <button
      class='base_button button_danger'
      @click="deleteInsertion"
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
      const confirmed = window.confirm('Tem certeza que deseja salvar?');
      if (confirmed) {
        this.$emit('saveEmit');
      }
    },
    cancelInsertion() {
      const confirmed = window.confirm('Tem certeza que deseja cancelar?');
      if (confirmed) {
        this.$emit('cancelEmit');
      }
    },
    deleteInsertion() {
      const confirmed = window.confirm('Tem certeza que deseja deletar?');
      if (confirmed) {
        this.$emit('deleteEmit');
      }
    },
  },
};
</script>
