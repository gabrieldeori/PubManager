// Logout laravel vue jwt-auth
<template>
  <div>
    <h1>Logout</h1>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserLogout',
  methods: {
    logout() {
      axios.post('http://localhost:8000/api/logout').then(() => {
        localStorage.removeItem('pubmanager_tk_009911');
        console.log('logout');
        this.$router.push({ name: 'Login' });
      }).catch((error) => {
        console.log('error', error.response.data);
      });
    },
  },
  mounted() {
    this.logout();
  },
};
</script>
