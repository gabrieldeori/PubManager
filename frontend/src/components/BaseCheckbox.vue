<template>
  <label :for="'id_' + name" class="input_label_side">
    <input
      type="checkbox"
      :checked="modelValue"
      @change="$emit('update:modelValue', $event.target.checked)"
      :id="'id_' + name"
      :name="name"
      class="input_checkbox"
    >
    <div class="input_label_side_text">
      {{ label }}
    </div>
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
