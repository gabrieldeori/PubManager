<template>
  <div :class="'color_component ' + propColor">
    {{ propColor }}
  </div>
</template>

<script>
export default {
  name: 'ColorComponent',
  props: {
    propColor: Object,
  },
};
</script>

<style scoped>
.color_component {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 1rem;
  background: violet;
}
.class_black {
  background-color: var(--black);
  color: white;
}
.class_smooth_black {
  background-color: var(--smooth_black);
  color: white;
}
.class_grey_1 {
  background-color: var(--grey_1);
  color: white;
}
.class_grey_2 {
  background-color: var(--grey_2);
  color: white;
}
.class_smooth_white {
  background-color: var(--smooth_white);
  color: var(--smooth_black);
}
.class_white {
  background-color: var(--white);
  color: black;
}

/* Primary */
.class_primary_darker {
  background-color: var(--primary_darker);
  color: var(--primary_white);
}
.class_primary_dark {
  background-color: var(--primary_dark);
  color: var(--primary_white);
}
.class_primary_stronger {
  background-color: var(--primary_stronger);
  color: var(--primary_white);
}
.class_primary_strong {
  background-color: var(--primary_strong);
  color: var(--primary_white);
}
.class_primary_light {
  background-color: var(--primary_light);
  color: var(--smooth_black);
}
.class_primary_lighter {
  background-color: var(--primary_lighter);
  color: var(--primary_stronger);
}
.class_primary_white {
  background-color: var(--primary_white);
  color: var(--primary_stronger);
}

/* Highlight */
.class_highlight_darker {
  background-color: var(--highlight_darker);
  color: var(--highlight_white);
}
.class_highlight_dark {
  background-color: var(--highlight_dark);
  color: var(--highlight_white);
}
.class_highlight_stronger {
  background-color: var(--highlight_stronger);
  color: var(--highlight_white);
}
.class_highlight_strong {
  background-color: var(--highlight_strong);
  color: var(--highlight_white);
}
.class_highlight_light {
  background-color: var(--highlight_light);
  color: var(--smooth_black);
}
.class_highlight_lighter {
  background-color: var(--highlight_lighter);
  color: var(--highlight_stronger);
}
.class_highlight_white {
  background-color: var(--highlight_white);
  color: var(--highlight_stronger);
}

/* Danger */
.class_danger_darker {
  background-color: var(--danger_darker);
  color: var(--danger_white);
}
.class_danger_dark {
  background-color: var(--danger_dark);
  color: var(--danger_white);
}
.class_danger_stronger {
  background-color: var(--danger_stronger);
  color: var(--danger_white);
}
.class_danger_strong {
  background-color: var(--danger_strong);
  color: var(--danger_white);
}
.class_danger_light {
  background-color: var(--danger_light);
  color: var(--smooth_black);
}
.class_danger_lighter {
  background-color: var(--danger_lighter);
  color: var(--danger_stronger);
}
.class_danger_white {
  background-color: var(--danger_white);
  color: var(--danger_stronger);
}

</style>
