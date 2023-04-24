<template>
  <label :for="'id_' + name">
    <input
      type="checkbox"
      :checked="modelValue"
      @change="$emit('update:modelValue', $event.target.checked)"
      :id="'id_' + name"
      :name="name"
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
      type: Boolean,
      default: false,
    },
  },
};
</script>
