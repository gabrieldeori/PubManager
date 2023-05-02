<template>
<main>
  <form @submit.prevent="login">
    <img src="@/assets/logo.png" alt="" width="72" height="57">
    <h1>Login</h1>

    <BaseInput
      name="email"
      label="Email"
      placeholder="Insira o email"
      type="email"
      v-model="form.email"
      :error="formErrors.name"
    />

    <BaseInput
      name="password"
      label="Senha"
      placeholder="Insira a senha"
      type="password"
      v-model="form.password"
      :error="formErrors.password"
    />

    <button class="base_button button_primary" type="submit">Login</button>
    <p>PubManager &copy; 2023–2026 - gabriel_deori</p>
  </form>
</main>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserLogin',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      formErrors: {
        email: '',
        password: '',
        page: '',
      },
    };
  },
  methods: {
    login() {
      axios.post('http://localhost:8000/api/login', {
        email: this.form.email,
        password: this.form.password,
      }).then((response) => {
        console.log(response);
        localStorage.setItem('pubmanager_tk_009911', response.data.access_token);
        // this.$router.push('/users/show');
      }).catch((error) => {
        console.log(error.response.data);
      });
    },
  },
};
</script>
