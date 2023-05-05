<template>
  <button
    class="btn btn-primary button_primary to_left_plz"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#offcanvasRight"
    aria-controls="offcanvasRight"
  >
    Menu
  </button>

  <div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="offcanvasRight"
    aria-labelledby="offcanvasRightLabel"
  >
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Menu de Operações</h5>
    <button
      type="button"
      class="btn-close"
      data-bs-dismiss="offcanvas"
      aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div>
      <div
        class="dropdown"
        v-for="menu in dropsMenus"
          v-bind:key="menu.group"
          :menu="menu"
      >
        <button
          class="btn btn-secondary base_button button_primary dropdown-toggle"
          type="button"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          {{ menu.group }}
        </button>
        <BasePubDropRouter
          :menu="menu"
        />
      </div>
    </div>
  </div>
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

<style scoped>
  .base_button {
    width: 100%;
  }

  .to_left_plz {
    display: flex;
  }
</style>
