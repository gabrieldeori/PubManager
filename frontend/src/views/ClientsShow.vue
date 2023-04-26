<!-- view to see the client list registered on db -->
<template>
  <section>
    <BaseError
      v-if="errorMessage.data"
      v-bind:errorMessage="errorMessage"
    />
    <BaseSuccess
      v-if="!errorMessage.data && successMessage"
      v-bind:successMessage="successMessage"
    />
    <h1>CLIENTS</h1>
    <BaseTableJSON
      v-bind:table_title="'Clients'"
      v-bind:table_data="responseClients"
    />
  </section>
</template>

<script>
import axios from 'axios';
import BaseTableJSON from '@/components/BaseTableJSON.vue';

export default {
  name: 'ClientsTable',
  data() {
    return {
      errorMessage: {},
      successMessage: '',
      responseClients: [],
    };
  },
  components: {
    BaseTableJSON,
  },
  methods: {
    getClients() {
      axios.get('http://127.0.0.1:8000/api/clients/show')
        .then((response) => {
          this.successMessage = response.data.message;
          this.responseClients = response.data.payload;
        })
        .catch((error) => {
          this.errorMessage = error;
        });
    },
  },
  mounted() {
    this.getClients();
  },
};
</script>
