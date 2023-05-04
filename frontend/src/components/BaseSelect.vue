<template>
  <label class="input_label" :for="'id_' + name">
    <div class="input_label_text">{{ label }}</div>
    <select
    :class="['input_area input_select', componentClass, { error: error }]"
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
    <div v-if="error" class="error_message">
      {{ error }}
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
    modelValue: {
      type: [String, Number],
      default: '',
    },
    options: {
      type: Array,
      required: true,
    },
    error: {
      type: String,
      default: '',
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

.input_area.error {
  border: 0.2rem solid var(--danger_stronger);
  color: var(--danger_stronger);
}

.error_message {
  color: var(--danger_stronger);
  padding: 0.25rem;
}
</style>
