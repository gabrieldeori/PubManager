<template>
    <p v-if="error" class="error_text">{{ error }}</p>
</template>

<script>
export default {
  name: 'BaseError',
  props: {
    error: {
      type: String,
      required: true,
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
