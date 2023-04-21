<template>
  <TextInputBase :inputProp="inputProp" />
  <TextInputBase :inputProp="inputProp2" />
</template>

<script>
import TextInputBase from './TextInputBase.vue';

export default {
  name: 'TextInputComponents',
  components: {
    TextInputBase,
  },
  data() {
    return {
      inputProp: {
        label: 'Input Label',
        iconsrc: '',
        type: 'text',
        name: 'teste',
        placeholder: 'Placeholder',
        value: '',
        pattern: '',
      },
      inputProp2: {
        label: 'Quantidade',
        iconsrc: '',
        type: 'number',
        name: 'quantity',
        placeholder: '(Opcional) Quantidade',
        value: '',
        pattern: '',
      },
    };
  },
};
</script>

<style scoped>
.textInput_components {
  display: flex;
  flex-flow: row wrap;
}
</style>
