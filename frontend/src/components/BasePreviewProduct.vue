<template>
  <div class="base_button button_highlight invert">
    {{ preview.name }} {{ preview.price }} x {{ preview.quantity }} = {{ preview.total_price }}
  </div>
</template>

<script>
export default {
  name: 'BasePreviewProduct',
  props: {
    preview: {
      type: Object,
      required: true,
    },
  },
};
</script>
