<template>
  <label
    class="input_label"
    :for="'id_' + name"
  >
    <div class="input_label_text">{{ label }}</div>
    <div
      :class="['input_area', componentClass, { error: error }]"
    >
      <img class="input_icon" :src="src" alt="" />
      <input
        :class="'input_tag '"
        :id="'id_' + name"
        :name="name"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="type"
        :required="required"
      >
    </div>
    <div v-if="error" class="error_message">
      {{ error }}
    </div>
  </label>
</template>

<script>
import iconDefault from '@/assets/icons/icon_default.svg';

export default {
  name: 'BaseInput',
  props: {
    label: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    modelValue: {
      type: [String, Number],
      default: '',
    },
    componentClass: {
      type: String,
      default: '',
    },
    error: {
      type: String,
      default: '',
    },
    src: {
      type: String,
      default: iconDefault,
    },
    required: {
      type: Boolean,
      default: false,
    },
    type: {
      type: String,
      default: 'text',
    },
  },
};
</script>

<style scoped>
.input_icon {
  height: 100%;
  width: 100%;
}

.input_area {
  align-items: center;
  background-color: var(--smooth_white);
  border: 0.1rem solid var(--grey_2);
  border-radius: 0.5rem;
  display: flex;
  justify-content: center;
  padding: 0.5rem;
  gap: 0.25rem;
}

.input_area:focus-within {
  border: 0.1rem solid var(--primary_stronger);
}

.input_tag {
  background-color: transparent;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1rem;
  border: none;
  width: fit-content;
  max-width: 100%;
  outline: none;
  padding: 0;
}

.input_tag::placeholder {
  color: var(--grey_2);
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
