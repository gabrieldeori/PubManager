<template>
  <div>
    <h1>Create an event</h1>
    <form @submit.prevent="sendForm">
      <BaseSelect
        v-model="event.category"
        label="Category"
        name="category"
        :options="categories"
      />

      <BaseInput
        v-model="event.title"
        label="Title"
        name="title_1"
        placeholder="Input title placeholder"
        type="text"
        componentClass="teste"
        error="Erro 1"
      />

      <BaseCheckbox
        v-model="event.extras.catering"
        name="catering"
        label="Catering"
      />
      <BaseCheckbox
        v-model="event.extras.music"
        name="music"
        label="Live music"
      />

      <BaseRadio
        v-model="event.pets"
        :value="true"
        label="Yes"
        name="pets"
      />

      <BaseRadio
        v-model="event.pets"
        :value="false"
        label="No"
        name="pets"
      />

      <BaseRadioGroup
        v-model="event.pets"
        :options="pets"
        name="pets"
      />
      <button type="submit">Submit</button>
    </form>
    <pre class="organiza">{{ event }}</pre>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: [
        'sustainability',
        'nature',
        'animal welfare',
        'housing',
        'education',
        'food',
        'community',
      ],
      event: {
        category: '',
        title: '',
        description: '',
        location: '',
        pets: false,
        extras: {
          catering: false,
          music: false,
        },
      },
      pets: [
        {
          value: true,
          label: 'Yes',
        },
        {
          value: false,
          label: 'No',
        },
      ],
    };
  },
  methods: {
    sendForm() {
      axios.post('http://localhost:3000/events', this.event)
        .then((response) => {
          console.log('Response: ', response);
        })
        .catch((error) => {
          console.log('Error: ', error);
        });
    },
  },
};
</script>

<style scoped>
.organiza {
  text-align: left;
}
</style>
