<template>
  <form>
    <BasicInput
      v-model="name"
      label="Name"
      placeholder="Enter your name"
      required
    />
  </form>
</template>

<script>
export default {
  name: "ClientRegister",
  components: {
    BasicInput,
  },
  data() {
    return {
      name: "",
    };
  },
};
</script>
