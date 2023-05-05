<template>
  <section>
    <BaseErrors :errors="errors" />
    <h1>Usuários</h1>
    <BaseTableJson
      :table_title="'Usuários'"
      :table_data="responseUsers"
      :is_crud="true"
      @updateEmit="updateUser"
      @deleteEmit="deleteUser"
    />
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UsersTable',
  data() {
    return {
      responseUsers: [],
      errors: {},
    };
  },
  methods: {
    async getUsers() {
      try {
        const response = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/users/show`);
        this.responseUsers = response.data.payload;
      } catch (errors) {
        const { response } = errors;
        if (!response) {
          this.errors.generic = errors.message;
        }
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
      }
    },
    async deleteUser(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          await axios.delete(`${process.env.VUE_APP_ROOT_API}/api/user/delete`, { data: { id } });
          this.$router.go();
        } catch (errors) {
          const { response } = errors;
          if (!response) {
            this.errors.generic = errors.message;
          }
          this.errors.title = response.data.message || '';
          this.errors.generic = response.data.payload.errors.generic || '';
          this.errors.specific = response.data.payload.errors.specific || '';
          this.errors.validation = response.data.payload.errors.validation || '';
        }
      }
    },
    updateUser(id) {
      this.$router.push(`/user/${id}`);
    },
  },
  mounted() {
    this.getUsers();
  },
};
</script>
