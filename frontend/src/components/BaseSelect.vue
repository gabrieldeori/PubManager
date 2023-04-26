<template>
  <label class="input_label" :for="'id_' + name">
    <div class="input_label_text">{{ label }}</div>
    <select
      class="input_select"
      :id="'id_' + name"
      :name="name"
      :value="modelValue"
      v-bind="{
        ...$attrs,
        onChange: ($event) => { $emit('update:modelValue', $event.target.value) },
      }"
    >
      <option
        v-for="option in options"
        :value="option"
        :key="option"
        :selected="option === modelValue"
      >{{ option }}</option>
    </select>
  </label>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      default: '',
    },
    modelValue: {
      type: [String, Number],
      default: '',
    },
    options: {
      type: Array,
      required: true,
    },
  },
};

</script>

<style scoped>
.input_select {
  background-color: var(--smooth_white);
  border: 0.1rem solid var(--grey_2);
  cursor: pointer;
}

.input_select {
  background-color: var(--smooth_white);
  border: 0.1rem solid var(--grey_2);
  border-radius: 0.2rem;
  cursor: pointer;
  font-size: 1rem;
}

.input_select:focus {
  background-color: var(--smooth_white);
  border: 0.1rem solid var(--primary_stronger);
  outline: none;
}

.input_select option:checked {
  background-color: var(--primary_stronger);
}

option::after {
  border: 2px solid red;
}
</style>
