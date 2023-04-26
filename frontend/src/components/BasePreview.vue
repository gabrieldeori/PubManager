<template>
  <div class="base_button button_black invert">
    <span v-for="element, index in Object.values(preview)" :key="'key_elem_' + index">
      {{ element }}&nbsp;
    </span>
  </div>
</template>

<script>
export default {
  name: 'BasePreview',
  props: {
    preview: {
      type: Object,
      required: true,
    },
  },
};
</script>
