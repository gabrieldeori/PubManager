<template>
  <section>
      <h3 class="error_title">{{ errors.title }}</h3>
      <p class="error_text">{{ errors.generic }}</p>
      <p class="error_text">{{ errors.specific }}</p>
      <ul>
        <li v-for="(error, _teste, key) in errors.validation" :key="key" class="error_text">
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

<style scoped>
.error_title {
  font-weight: bolder;
  color: var(--danger_light);
}

.error_text {
  color: var(--danger_strong);
}
</style>
