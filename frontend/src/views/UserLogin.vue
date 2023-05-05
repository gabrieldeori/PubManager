<template>
<main>
  <form @submit.prevent="login">
    <img src="@/assets/icons/PubManager.png" alt="" width="72" height="57">
    <h1>Login</h1>

    <BaseErrors :errors="errors" />

    <BaseInput
      name="email"
      label="Email"
      placeholder="Insira o email"
      type="email"
      v-model="form.email"
      :error="formularyErrors.name"
    />

    <BaseInput
      name="password"
      label="Senha"
      placeholder="Insira a senha"
      type="password"
      v-model="form.password"
      :error="formularyErrors.password"
    />

    <button class="base_button button_primary" type="submit">Login</button>
  </form>
</main>
</template>

<script>
import axios from 'axios';
// import * as yup from '@/helpers/yupbrasil';

// const schema = yup.object().shape({
//   email: yup.string().required().email(),
//   password: yup.string().required().min(6).max(255),
// });

export default {
  name: 'UserLogin',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      formularyErrors: {},
      errors: {},
    };
  },
  methods: {
    async login() {
      try {
        // await schema.validate(this.form, { abortEarly: false });
        const response = await axios.post(`${process.env.BASE_URL}/login`, {
          email: this.form.email,
          password: this.form.password,
        });
        const toString = JSON.stringify(response.data);
        localStorage.setItem('pubmanager_tk_009911', toString);
        this.$router.push('/users/show');
      } catch (errors) {
        if (false) {
          errors.inner.forEach((e) => {
            this.formularyErrors[e.path] = e.message;
          });
        } else {
          const { response } = errors;
          if (!response) {
            this.errors.generic = errors.message;
            return;
          }
          this.errors.title = response.data.message;
          this.errors.generic = response.data.payload.errors.generic;
          this.errors.specific = response.data.payload.errors.specific;
          this.errors.validation = response.data.payload.errors.validation;
        }
      }
    },
  },
};
</script>

<style scoped>
img {
  margin-bottom: 1rem;
  height: 6rem;
  width: 6rem;
}
</style>
