<template>
  <button
    class="btn btn-secondary button_primary dropdown-toggle"
    type="button"
    data-bs-toggle="dropdown"
    aria-expanded="false"
  >
    {{ menu.group }}
  </button>
  <ul class="dropdown-menu">
    <li
      v-for="option in menu.options"
      v-bind:key="option.id"
    >
      <router-link :to="option.link">{{ option.title }}</router-link>
    </li>
  </ul>
</template>

<script>
export default {
  name: 'BasePubDropDown',
  props: {
    menu: {
      type: Array,
      required: true,
    },
  },
};
</script>
