<template>
  <div v-if="preview && products.length > 0" class="base_button button_highlight invert">
    {{ products[preview.product_id].name }}
     R$ {{ preview.price }}
     x {{ preview.quantity }} = R$ {{ preview.total_price }}
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
    products: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
};
</script>
