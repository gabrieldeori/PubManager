<template>
  <section>
    <h2>CLIENTS</h2>

    <BaseErrors :errors="this.errors" />

    <BaseTableJson
      :table_title="'Clients'"
      :table_data="responseClients"
      :is_crud="true"
      @updateEmit="updateClient"
    />
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientsTable',
  data() {
    return {
      errors: {},
      responseClients: [],
    };
  },
  methods: {
    async getClients() {
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/clients/show`);
        this.responseClients = data.payload;
      } catch (errors) {
        const { response } = errors;
        if (!response) {
          this.errors.generic = errors.message;
          return;
        }
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
      }
    },
    updateClient({ id }) {
      this.$router.push(`/client/${id}`);
    },
  },
  mounted() {
    this.getClients();
  },
};
</script>
