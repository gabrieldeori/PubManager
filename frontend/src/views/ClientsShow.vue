<!-- view to see the client list registered on db -->
<template>
  <div class="clients_table">
    <h1>CLIENTS</h1>
    <table>
      <thead>
        <tr>
          <th>Nome</th>
          <th>Criado em</th>
          <th>Atualizado em</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="client in clients" :key="client.id">
          <td>
            {{ client.name }}
          </td>
          <td>{{ client.created_at }}</td>
          <td>{{ client.updated_at }}</td>
          <td>
            <router-link :to="{ name: '', params: { id: client.id } }">
              Edit
            </router-link>
          </td>
          <td>
            <router-link :to="{ name: '', params: { id: client.id } }">
             Delete
            </router-link>
          </td>
        </tr>
      </tbody>
      <h2>Structure</h2>
      <pre>
        {{ clients }}
      </pre>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientsTable',
  data() {
    return {
      clients: [],
    };
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
