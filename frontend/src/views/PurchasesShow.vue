<template>
  <section>
    <h1>Compras</h1>

    <BaseErrors :errors="errors" />

    <BaseTableJson
      :table_title="'Compras'"
      :table_data="responsePurchases"
      :is_crud="true"
      @updateEmit="updatePurchase"
      @deleteEmit="deletePurchase"
    />
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PurchasesShow',
  data() {
    return {
      errors: {},
      responsePurchases: [],
    };
  },
  methods: {
    async getPurchases() {
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/purchases/show`);
        this.responsePurchases = data.payload.purchases;
      } catch (errors) {
        const { response } = errors;
        if (!response.data.payload.errors && !response.data.payload && !response) {
          this.errors.generic = errors.message;
          return;
        }
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
      }
    },
    async deletePurchase(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          await axios.delete(`${process.env.VUE_APP_ROOT_API}/api/purchase/delete`, { data: { id } });
          alert('Compra deletada com sucesso!');
          this.$router.go();
        } catch (errors) {
          const { response } = errors;
          if (!response.data.payload.errors && !response.data.payload && !response) {
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
    updatePurchase({ id }) {
      this.$router.push(`/purchase/${id}`);
    },
  },
  mounted() {
    this.getPurchases();
  },
};
</script>
