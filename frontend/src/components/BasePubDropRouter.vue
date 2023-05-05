<template>
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
  ul {
    background-color: var(--primary_white);
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    width: 100%;
  }

  li {
    width: 100%;
  }

  .dropdown-item {
    color: var(--smooth_black);
  }

  .dropdown-item:hover {
    background-color: var(--primary_light);
  }
</style>
