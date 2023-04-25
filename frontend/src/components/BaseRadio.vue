<template>
  <label class="input_label_side" :for="'id_' + value">
    <input
      type="radio"
      :checked="modelValue === value"
      :value="value"
      :id="'id_' + value"
      @change="$emit('update:modelValue', value)"
      v-bind="$attrs"
      class="radio_button"
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

<style scoped>
.radio_button {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 2px solid #ccc;
  outline: none;
  cursor: pointer;
  position: relative;
}

.radio_button::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #fff;
  transform: translate(-50%, -50%);
}

.radio_button:checked::before {
  background-color: var(--primary_stronger);
  border: 0.2rem solid var(--primary_stronger);
}

.radio_button:focus-within {
  border: 0.1rem solid var(--primary_light);
}

.radio_button.error {
  border: 0.1rem solid var(--danger_stronger);
  color: var(--danger_stronger);
}

.error_message {
  color: var(--danger_stronger);
  padding: 0.25rem;
}
</style>
