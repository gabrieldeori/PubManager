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
import BasePubDropRouter from './BasePubDropRouter.vue';

export default {
  name: 'BasePubDropDown',
  components: {
    BasePubDropRouter,
  },
  props: {
    dropsMenus: {
      type: Array,
      required: true,
    },
  },
};
</script>
