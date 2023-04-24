<template>
  <BaseRadio
    v-for="{ value, label } in options"
    :key="'key_' + value"
    :value="value"
    :label="label"
    :name="name"
    :modelValue="modelValue"
    @update:modelValue="$emit('update:modelValue', $event)"
   />
</template>

<script>
export default {
  props: {
    options: {
      type: Array,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    modelValue: {
      type: [String, Number, Boolean],
      required: true,
    },
  },
};
</script>
