<template>
  <div class="button_component">
    <button class="base_button button_black">
      botão
    </button>
    <button class="base_button button_black invert">
      botão
    </button>
    <button class="base_button button_primary">
      botão
    </button>
    <button class="base_button button_primary invert">
      botão
    </button>
    <button class="base_button button_highlight">
      botão
    </button>
    <button class="base_button button_highlight invert">
      botão
    </button>
    <button class="base_button button_danger">
      botão
    </button>
    <button class="base_button button_danger invert">
      botão
    </button>
  </div>
</template>

<script>

export default {
  name: 'ButtonsComponent',
};
</script>

<style scoped>
  .button_component {
    display: flex;
    flex-flow: row wrap;
  }
</style>
