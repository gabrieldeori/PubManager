<template>
  <div class="dropdown">
    <BasePubDropRouter
      v-for="menu in dropsMenus"
      v-bind:key="menu.group"
      :menu="menu"
    />
  </div>
</template>

<script>
export default {
  name: 'BasePubDropDown',
  props: {
    dropsMenus: {
      type: Array,
      required: true,
    },
  },
};
</script>
