<template>
  <div class="button_component">
    <button class="base_button button_black">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_black invert">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_primary">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_primary invert">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_highlight">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_highlight invert">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_danger">
      <img src="" alt="">
      botão
      <img src="" alt="">
    </button>
    <button class="base_button button_danger invert">
      <img src="" alt="">
      botão
      <img src="" alt="">
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
