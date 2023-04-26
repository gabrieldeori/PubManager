<template>
  <div>
    <h2 class="error_title">{{ errorMessage.response.data.message }}</h2>
    <p class="error_text">{{ errorMessage.response.data.payload.error }}</p>
  </div>
</template>

<script>
export default {
  name: 'BaseError',
  props: {
    errorMessage: {
      type: Object,
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
