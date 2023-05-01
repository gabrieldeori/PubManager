<template>
  <section class="radio_group">
    <BaseRadio
      v-for="{ value, label } in options"
      :key="'key_' + value"
      :value="value"
      :label="label"
      :name="name"
      :modelValue="modelValue"
      @update:modelValue="$emit('update:modelValue', $event)"
     />
  </section>
  <BaseErrorInputs
      :error="error"
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
    error: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
  .radio_group {
    display: flex;
    flex-flow: row wrap;
    gap: 1rem;
    max-width: 100%;
  }
</style>
