<template>
  <section>
    <BaseError
      v-if="errorData"
      :errorData="errorData"
    />
    <h1>CLIENTS</h1>
    <BaseTableJSON
      :table_title="'Usuários'"
      :table_data="responseUsers"
      :is_crud="true"
      @updateEmit="updateAdmin"
      @deleteEmit="deleteUser"
    />
  </section>
</template>

<script>
import axios from 'axios';
import BaseTableJSON from '@/components/BaseTableJSON.vue';

export default {
  name: 'UsersTable',
  data() {
    return {
      errorData: null,
      responseUsers: [],
    };
  },
  components: {
    BaseTableJSON,
  },
  methods: {
    getUsers() {
      axios.get('http://localhost:8000/api/users/show')
        .then((response) => {
          this.responseUsers = response.data.payload;
          console.log(response);
        })
        .catch((error) => {
          this.errorData = error;
          console.log('erro:');
          console.log(error);
        });
    },
    deleteUser(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        axios.delete('http://localhost:8000/api/user/delete', { data: { id } })
          .then(() => {
            alert('Usuário deletado com sucesso!');
            this.$router.go();
          })
          .catch(() => {
            alert('Erro ao deletar usuário!');
          });
      }
    },
    updateAdmin(id) {
      this.$router.push(`/user/${id}`);
    },
  },
  mounted() {
    this.getUsers();
  },
};
</script>
