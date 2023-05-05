<template>
  <div class="flex_horizontal">
    <button
      v-if="saveTxt !== 'Cadastrar'"
      type="button"
      class='base_button button_highlight'
      @click.prevent="saveInsertion"
    >
      {{ saveTxt }}
    </button>

    <button
      v-else
      type="button"
      class='base_button button_primary'
      @click.prevent="saveInsertion"
    >
      {{ saveTxt }}
    </button>

    <button
      type="button"
      class='base_button button_danger invert'
      @click.prevent="cancelInsertion"
    >
      {{ cancelTxt }}
    </button>
    <button
      type="button"
      class='base_button button_danger'
      @click.prevent="deleteInsertion"
    >
      {{ deleteTxt }}
    </button>
  </div>
</template>

<script>
export default {
  name: 'BaseEditButtons',
  props: {
    saveTxt: {
      type: String,
      default: 'Cadastrar',
    },
    cancelTxt: {
      type: String,
      default: 'Cancelar',
    },
    deleteTxt: {
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
