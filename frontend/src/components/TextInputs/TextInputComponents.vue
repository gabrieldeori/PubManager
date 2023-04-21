<template>
  <div class="textInput_components">
    <label class="label_wrapper" for="nome">
      <div class="label_class">Input Label</div>
      <div class="wrapper">
        <div>O<img src="" alt=""></div>
        <input
          class="default_text_input" type="text" name="nome" id="nome" placeholder="Placeholder"
          value=""
        >
      </div>
    </label>
  </div>
</template>

<script>

export default {
  name: 'TextInputComponents',
};
</script>

<style scoped>
.textInput_components {
  display: flex;
  flex-flow: row wrap;
}

.label_wrapper {
  background-color: #0000;
  display: flex;
  flex-flow: column;
  align-items: flex-start;
  margin: 0.5rem 0 0.5rem 0;
}

.label_class {
  margin-left: 0.5rem;
}

.wrapper {
  background-color: var(--smooth_white);
  border: 0.05rem solid var(--smooth_black);
  border-radius: 0.5rem;
  display: flex;
  padding: 0.25rem 0.5rem;
}

.wrapper:focus-within {
  border: 0.1rem solid var(--primary_stronger);
  border-radius: 0.5rem;
}

.default_text_input {
  background-color: #0000;
  border: none;
  outline: none;
}
</style>
