<template>
  <section>
    <h2>Produtos</h2>

    <BaseErrors :errors="errors"/>

    <BaseTableJson
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

export default {
  name: 'ProductsShow',
  data() {
    return {
      errors: {},
      responseProducts: [],
    };
  },
  methods: {
    async getProducts() {
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/products/show`);
        this.responseProducts = data.payload.products;
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
    async deleteProduct(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          await axios.delete(`${process.env.VUE_APP_ROOT_API}/api/product/delete`, { data: { id } });
          alert('Produto deletado com sucesso!');
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
    updateProduct({ id }) {
      this.$router.push(`/product/${id}`);
    },
  },
  mounted() {
    this.getProducts();
  },
};
</script>
