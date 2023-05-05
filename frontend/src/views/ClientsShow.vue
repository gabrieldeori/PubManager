<template>
  <section>
    <h1>CLIENTS</h1>

    <BaseErrors :errors="this.errors" />

    <BaseTableJson
      :table_title="'Clients'"
      :table_data="responseClients"
      :is_crud="true"
      @updateEmit="updateClient"
      @deleteEmit="deleteClient"
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
        const { data } = await axios.get('http://localhost:8000/api/clients/show');
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
    async deleteClient(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          await axios.delete('http://localhost:8000/api/client/delete', { data: { id } });
          alert('Cliente deletado com sucesso!');
          this.$router.go();
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
      }
    },
    updateClient(id) {
      this.$router.push(`/client/${id}`);
    },
  },
  mounted() {
    this.getClients();
  },
};
</script>
