<template>
  <div class="palette_rowwrap">
    <div class='palette_component'>
      <ColorComponent
        v-for="(class_color, index) in classesColorBase"
        v-bind:key="index"
        :propColor="class_color"
      />
    </div>
    <div class='palette_component'>
      <ColorComponent
        v-for="(class_color, index) in classesColorPrimary"
        v-bind:key="index"
        :propColor="class_color"
      />
    </div>
    <div class='palette_component'>
      <ColorComponent
        v-for="(class_color, index) in classesColorHighlight"
        v-bind:key="index"
        :propColor="class_color"
      />
    </div>
    <div class='palette_component'>
      <ColorComponent
        v-for="(class_color, index) in classesColorDanger"
        v-bind:key="index"
        :propColor="class_color"
      />
    </div>
  </div>
</template>

<script>
import ColorComponent from '@/components/design/ColorComponent.vue';

export default {
  name: 'PaletteComponent',
  components: {
    ColorComponent,
  },
  data() {
    return {
      classesColorBase: [
        'class_black',
        'class_smooth_black',
        'class_grey_1',
        'class_grey_2',
        'class_smooth_white',
        'class_white',
      ],
      classesColorPrimary: [
        'class_primary_darker',
        'class_primary_dark',
        'class_primary_stronger',
        'class_primary_strong',
        'class_primary_light',
        'class_primary_lighter',
        'class_primary_white',
      ],
      classesColorHighlight: [
        'class_highlight_darker',
        'class_highlight_dark',
        'class_highlight_stronger',
        'class_highlight_strong',
        'class_highlight_light',
        'class_highlight_lighter',
        'class_highlight_white',
      ],
      classesColorDanger: [
        'class_danger_darker',
        'class_danger_dark',
        'class_danger_stronger',
        'class_danger_strong',
        'class_danger_light',
        'class_danger_lighter',
        'class_danger_white',
      ],
    };
  },
};
</script>

<style scoped>
.palette_rowwrap {
  display: flex;
  flex-flow: row wrap;
}
.palette_component {
  display: flex;
  flex-direction: column;
}
</style>
