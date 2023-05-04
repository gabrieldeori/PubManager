// Logout laravel vue jwt-auth
<template>
  <div>
    <h1>Logout</h1>
    <BaseErrors :errors="errors" />
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserLogout',
  data() {
    return {
      errors: {},
    };
  },
  methods: {
    async logout() {
      try {
        await axios.post('http://localhost:8000/api/logout');
        localStorage.removeItem('pubmanager_tk_009911');
        this.$router.push({ name: 'Login' });
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
  },
  mounted() {
    this.logout();
  },
};
</script>
