<template>
  <section>
      <h3>{{ errors.title }}</h3>
      <p>{{ errors.generic }}</p>
      <p>{{ errors.specific }}</p>
      <ul>
        <li v-for="(error, _teste, key) in errors.validation" :key="key">
          {{ error }}
        </li>
      </ul>
  </section>
</template>

<script>
export default {
  name: 'BaseErrors',
  props: {
    errors: {
      type: Object,
      required: true,
      default() {
        return {
          title: '',
          generic: '',
          specific: '',
          validation: {},
        };
      },
    },
  },
};
</script>
