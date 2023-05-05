<template>
  <button
    class="btn btn-secondary base_button button_primary dropdown-toggle"
    type="button"
    data-bs-toggle="dropdown"
    aria-expanded="false"
  >
    {{ menu.group }}
  </button>
  <ul class="dropdown-menu ">
    <li
      v-for="option in menu.options"
      v-bind:key="option.id"
    >
      <router-link
        :to="option.link"
        class="dropdown-item"
      >{{ option.title }}</router-link>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'BasePubDropDown',
  props: {
    menu: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
  .base_button {
    max-width: 7rem;
  }
</style>
