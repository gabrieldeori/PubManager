<!-- view to see the client list registered on db -->
<template>
  <section>
    <BaseError
      v-if="errorMessage.data"
      :errorMessage="errorMessage"
    />
    <BaseSuccess
      v-if="!errorMessage.data && successMessage"
      :successMessage="successMessage"
    />
    <h1>CLIENTS</h1>
    <BaseTableJSON
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
    deleteClient(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        axios.delete('http://localhost:8000/api/client/delete', { data: { id } })
          .then(() => {
            alert('Cliente deletado com sucesso!');
            this.$router.go();
          })
          .catch(() => {
            alert('Erro ao deletar cliente!');
          });
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
