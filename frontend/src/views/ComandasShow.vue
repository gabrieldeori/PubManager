<template>
  <section>
    <h1>Comandas</h1>

    <BaseErrors :errors="errors" />

    <BaseTableJson
      :table_title="'Comandas'"
      :table_data="responseComandas"
      :is_crud="true"
      @updateEmit="updateComanda"
      @deleteEmit="deleteComanda"
    />
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ComandasShow',
  data() {
    return {
      errors: {},
      responseComandas: [],
    };
  },
  methods: {
    async getComandas() {
      try {
        const { data } = await axios.get(`${process.env.BASE_URL}/comandas/show`);
        this.responseComandas = data.payload.comandas;
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
    async deleteComanda(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          await axios.delete(`${process.env.BASE_URL}/comanda/delete`, { data: { id } });
          alert('Compra deletada com sucesso!');
          this.$router.go();
        } catch (errors) {
          const { response } = errors;
          if (!response) {
            this.errors.generic = errors.message;
            return;
          }
          this.errors.title = response.data.message;
          this.errors.generic = response.data.payload.errors.generic || '';
          this.errors.specific = response.data.payload.errors.specific || '';
          this.errors.validation = response.data.payload.errors.validation || '';
        }
      }
    },
    updateComanda(id) {
      this.$router.push(`/comanda/${id}`);
    },
  },
  mounted() {
    this.getComandas();
  },
};
</script>
