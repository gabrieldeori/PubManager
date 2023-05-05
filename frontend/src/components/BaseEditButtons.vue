<template>
  <div class="flex_horizontal">
    <button
      type="button"
      class='base_button button_primary'
      @click.prevent="saveInsertion"
    >
      {{ txtRegister }}
    </button>

    <button
      type="button"
      class='base_button button_danger invert'
      @click.prevent="cancelInsertion"
    >
      {{ txtCancel }}
    </button>
    <button
      type="button"
      class='base_button button_danger'
      @click.prevent="deleteInsertion"
    >
      {{ txtDelete }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'BaseEditButtons',
  props: {
    txtRegister: {
      type: String,
      default: 'Cadastrar',
    },
    txtCancel: {
      type: String,
      default: 'Cancelar',
    },
    txtDelete: {
      type: String,
      default: 'Deletar',
    },
  },
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
