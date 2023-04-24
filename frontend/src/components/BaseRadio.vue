<template>
  <label :for="'id_' + value">
    <input
      type="radio"
      :checked="modelValue === value"
      :value="value"
      :id="'id_' + value"
      @change="$emit('update:modelValue', value)"
      v-bind="$attrs"
    >
    {{ label }}
  </label>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    modelValue: {
      type: [String, Number, Boolean],
      default: false,
    },
    value: {
      type: [String, Number, Boolean],
      required: true,
    },
  },
};
</script>
