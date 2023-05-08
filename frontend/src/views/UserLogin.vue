<template>
<main>
  <form @submit.prevent="">
    <img src="@/assets/icons/PubManager.png" alt="" width="72" height="57">
    <h2>Login</h2>

    <BaseErrors :errors="errors" />

    <BaseInput
      name="email"
      label="Email"
      placeholder="Insira o email"
      type="email"
      v-model="form.email"
      :error="formularyErrors.email"
    />

    <BaseInput
      name="password"
      label="Senha"
      placeholder="Insira a senha"
      type="password"
      v-model="form.password"
      :error="formularyErrors.password"
    />

    <BaseEditButtons
      :notDelete="true"
      cancelTxt="Voltar"
      saveTxt="Login"
      value="Login"
      @cancelEmit="this.$router.push('/')"
      @saveEmit="login"
    />
  </form>
</main>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape({
  email: yup.string().required().email(),
  password: yup.string().required().min(6),
});

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
        this.formularyErrors = {};
        await schema.validate(this.form, { abortEarly: false });
        const response = await axios.post(`${process.env.VUE_APP_ROOT_API}/login`, {
          email: this.form.email,
          password: this.form.password,
        });
        console.log(response);
        const toString = JSON.stringify(response.data.payload.token);
        localStorage.setItem('pubmanager_tk_009911', toString);
        this.$router.push('/users/show');
      } catch (errors) {
        console.log(errors);
        if (errors instanceof yup.ValidationError) {
          errors.inner.forEach((error) => {
            console.log(error);
            this.formularyErrors[error.path] = error.message;
          });
          return;
        }
        const { response } = errors;
        if (!response) {
          if (!errors.message) {
            this.errors.generic = 'Email ou senha incorretos';
            return;
          }
          this.errors.generic = errors.message;
          return;
        }
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
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
