<template>
  <section>

  </section>
</template>

<script>
export default {
  name: 'Productedit',
  data() {
    return {
      errors: {},
      responseProduct: [],
      form: {
        name: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: '',
        password_old: '',
        userType: 'Nenhum',
      },
    };
  },
  methods: {
    getUser() {
      const payload = { id: this.$route.params.id };
      axios.get('http://localhost:8000/api/product', { params: payload })
        .then((response) => {
          this.responseProducts = response.data.payload.products;
        })
        .catch(({ response }) => {
          this.errors = response.data.payload.errors;
          this.errors.title = response.data.message;
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
            this.errors = response.data.payload.errors;
            this.errors.title = response.data.message;
          });
      }
    },
    updateProduct(id) {
      this.$router.push(`/product/${id}`);
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>
