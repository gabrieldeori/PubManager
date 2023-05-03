<template>
  <section>
    <h1>Compras</h1>

    <BaseErrors :errors="errors" />

    <BaseTableJSON
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
import BaseTableJSON from '@/components/BaseTableJSON.vue';

export default {
  name: 'PurchasesShow',
  data() {
    return {
      errors: {},
      responsePurchases: [],
    };
  },
  components: {
    BaseTableJSON,
  },
  methods: {
    getPurchases() {
      axios.get('http://localhost:8000/api/purchases/show')
        .then((response) => {
          console.log(response);
          this.responsePurchases = response.data.payload.purchases;
        })
        .catch((error) => {
          console.log(error);
          this.errors.title = error.response.data.message || '';
          this.errors.generic = error.response.data.payload.errors.generic || '';
          this.errors.specific = error.response.data.payload.errors.specific || '';
          this.errors.validation = error.response.data.payload.errors.validation || '';
        });
    },
    deletePurchase(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        axios.delete('http://localhost:8000/api/purchase/delete', { data: { id } })
          .then(() => {
            this.$router.go();
          })
          .catch(({ response }) => {
            this.errors.title = response.data.message;
            this.errors.generic = response.data.payload.errors.generic || '';
            this.errors.specific = response.data.payload.errors.specific || '';
            this.errors.validation = response.data.payload.errors.validation || '';
          });
      }
    },
    updatePurchase(id) {
      this.$router.push(`/purchases/edit/${id}`);
    },
  },
  mounted() {
    this.getPurchases();
  },
};
</script>
