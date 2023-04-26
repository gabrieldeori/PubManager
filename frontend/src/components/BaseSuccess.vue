<template>
  <div>
    <p class="success_text">{{ successMessage }}</p>
  </div>
</template>

<script>
export default {
  name: 'BaseError',
  props: {
    successMessage: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
.success_text {
  color: var(--success_strong);
}
</style>
