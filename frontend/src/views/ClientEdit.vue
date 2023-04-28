<template>
  <section>
    <h1>Editar Cliente</h1>

    <BaseError
      v-if="errorData"
      :errorData="errorData"
    />

    <div v-if="toEdit !== null">
      <h3>{{ toEdit.id }} - {{ toEdit.name }}</h3>

      <BaseInput
        v-model="toEdit.name"
        label='Nome'
        type='text'
        placeholder='Apenas letras e espaços'
        required
      />

      <p>Criado em: {{ toEdit.created_at }}</p>
      <p>Atualizado em: {{ toEdit.updated_at }}</p>

      <button
        class="base_button button_primary"
        @click="editClient()"
        >
          Atualizar
      </button>
      <button
        class="base_button button_danger invert"
        @click="this.$router.push(`/clients/show`)"
      >
        Cancelar
      </button>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientEdit',
  data() {
    return {
      toEdit: null,
      errorData: null,
    };
  },
  methods: {
    async getClient() {
      const payload = { id: this.$route.params.id };
      try {
        const { data } = await axios.get('http://localhost:8000/api/client', { params: payload });
        this.toEdit = data.payload.client;
      } catch (error) {
        this.errorData = error;
      }
    },
    async editClient() {
      const confirmed = window.confirm('Deseja realmente atualizar este cliente?');
      if (confirmed) {
        const payload = { ...this.toEdit };
        try {
          const { data } = await axios.put('http://localhost:8000/api/client/edit', payload);
          window.alert(data.message);
          this.$router.push('/clients/show');
        } catch (error) {
          window.alert(error.response.data.message);
        }
      }
    },
  },
  mounted() {
    this.getClient();
  },
};
</script>
