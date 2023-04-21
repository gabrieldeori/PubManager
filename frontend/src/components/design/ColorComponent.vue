<template>
  <div class="color_component">
    Black
  </div>
</template>

<script>
export default {
  name: 'ColorComponent',
};
</script>

<style scoped>
.color_component {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 20px;

  width: 80px;
  height: 10px;

  background: #000000;

  flex: none;
  order: 0;
  align-self: stretch;
  flex-grow: 0;
}
</style>
