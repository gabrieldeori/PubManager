<template>
  <div class="textInput_components">
    <form action="">
      <label class="label" for="nome">Nome:
        <div class="wrapper">
          <!-- <div>icon</div> -->
          <input class="default_text_input" type="text" name="nome" id="nome">
        </div>
      </label>
    </form>
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

.wrapper {
  background-color: var(--smooth_white);
  border: 0.05rem solid var(--smooth_black);
  border-radius: 0.5rem;
  display: flex;
}

.wrapper :focus {
  border: 0.1rem solid var(--primary_stronger);
  border-radius: 0.5rem;
}

.default_text_input {
  background-color: #0000;
  border: none;
  outline: none;
}
</style>
