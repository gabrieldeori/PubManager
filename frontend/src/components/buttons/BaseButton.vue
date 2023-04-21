<template>
  <div>
    <button :class="'base_button ' + buttonProp.class">

    </button>
  </div>
</template>

<script>
export default {
  name: 'BaseButton.vue',
  props: {
    buttonProp: Object,
  },
};
</script>

<style scoped>
</style>
