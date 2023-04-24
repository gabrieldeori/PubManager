<template>
  <label class="input_label" :for="'id_' + name">
    {{ label }}
    <div :class="'input_area ' + errorClass" >
      <img class="input_icon" src="" alt="">O
      <input
        :class="'input_tag '"
        :id="'id_' + name"
        :name="name"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      >
    </div>
  </label>
</template>

<script>
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
      type: String,
      default: '',
    },
    componentClass: {
      type: String,
      default: '',
    },
    errorClass: {
      type: String,
      default: '',
    },
  },
};
</script>

<style scoped>
.input_label {
  align-items: flex-start;
  border: none;
  display: flex;
  flex-flow: column;
  font-size: 1rem;
  justify-content: center;
  margin-bottom: 0.25rem;
  max-width: 100%;
  padding: 0.25rem;
  width: fit-content;
}

.input_icon {
  height: 100%;
  width: 100%;
}

.input_area {
  align-items: center;
  border: 1px solid var(--grey_2);
  border-radius: 1rem;
  display: flex;
  justify-content: center;
  padding: 0.25rem;
  gap: 0.25rem;
}

.input_area:focus-within {
  border: 2px solid var(--primary_stronger);
}

.input_tag {
  background-color: transparent;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.25rem;
  border: none;
  border-radius: 0.5rem;
  width: fit-content;
  max-width: 100%;
  outline: none;
  padding: 0;
}

.input_area.error {
  border: 0.1rem solid var(--danger_stronger);
  color: var(--danger_stronger);
}
</style>
