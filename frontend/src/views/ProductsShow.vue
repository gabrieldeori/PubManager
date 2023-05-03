<template>
  <section>
    <h1>Produtos</h1>

    <BaseErrors :errors="errors"/>

    <BaseTableJSON
      :table_title="'Usuários'"
      :table_data="responseProducts"
      :is_crud="true"
      @updateEmit="updateProduct"
      @deleteEmit="deleteProduct"
    />
  </section>
</template>

<script>
import axios from 'axios';
import BaseTableJSON from '@/components/BaseTableJSON.vue';

export default {
  name: 'ProductsShow',
  data() {
    return {
      errors: {},
      responseProducts: [],
    };
  },
  components: {
    BaseTableJSON,
  },
  methods: {
    getUsers() {
      axios.get('http://localhost:8000/api/products/show')
        .then((response) => {
          this.responseProducts = response.data.payload.products;
        })
        .catch(({ response }) => {
          this.errors.title = response.data.message;
          this.errors.generic = response.data.payload.errors.generic;
          this.errors.specific = response.data.payload.errors.specific;
          this.errors.validation = response.data.payload.errors.validation;
        });
    },
    deleteProduct(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        axios.delete('http://localhost:8000/api/product/delete', { data: { id } })
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
    updateProduct(id) {
      this.$router.push(`/product/${id}`);
    },
  },
  mounted() {
    this.getUsers();
  },
};
</script>
