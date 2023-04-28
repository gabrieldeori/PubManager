<template>
  <div>
    <h2 class="error_title">{{ errorData.response.data.message }}</h2>
    <p class="error_text">{{ errorData.response.data.payload.error }}</p>
  </div>
</template>

<script>
export default {
  name: 'BaseError',
  props: {
    errorData: {
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
