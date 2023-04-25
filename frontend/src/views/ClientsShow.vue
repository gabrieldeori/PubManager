<!-- view to see the client list registered on db -->
<template>
  <section>
    <h1>CLIENTS</h1>
    <BaseTableJSON
      v-bind:table_title="'Clients'"
      v-bind:table_data="clients"
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
      clients: [],
    };
  },
  components: {
    BaseTableJSON,
  },
  methods: {
    getClients() {
      axios.get('http://127.0.0.1:8000/api/clients/show')
        .then((response) => {
          this.clients = response.data;
        });
    },
  },
  mounted() {
    this.getClients();
  },
};
</script>
