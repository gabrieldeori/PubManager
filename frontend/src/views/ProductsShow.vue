<template>
  <section>
    <h1>Produtos</h1>

    <BaseError
      v-if="errorData"
      :errorData="errorData"
    />

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
      errorData: null,
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
          this.responseProducts = response.data.payload;
        })
        .catch((error) => {
          this.errorData = error;
        });
    },
    deleteProduct(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        axios.delete('http://localhost:8000/api/product/delete', { data: { id } })
          .then(() => {
            alert('Produto deletado com sucesso!');
            this.$router.push({ name: 'ProductsShow' });
          })
          .catch(() => {
            alert('Erro ao deletar produto!');
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
