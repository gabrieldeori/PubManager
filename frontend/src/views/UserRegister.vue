<template>
  <section>
    <h1>form</h1>
    <form class="base_form" @submit.prevent="sendForm">
      <BaseInput
        name="name"
        label="Nome"
        placeholder="Apenas letras e espaços em branco"
        type="text"
        v-model="form.name"
        :error="formularyErrors.name"
      />
      <BaseInput
        name="nickname"
        label="Nome de usuário"
        placeholder="Apenas letras"
        type="text"
        v-model="form.nickname"
        :error="formularyErrors.nickname"
      />
      <BaseInput
        name="email"
        label="E-mail"
        placeholder="Digite seu e-mail"
        type="email"
        v-model="form.email"
        :error="formularyErrors.email"
      />
      <BaseInput
        name="password"
        label="Senha"
        placeholder="Mínimo 6 caracteres"
        type="password"
        v-model="form.password"
        :error="formularyErrors.password"
      />
      <BaseInput
        name="password_confirmation"
        label="Confirmação de senha"
        placeholder="Repita a senha"
        type="password"
        v-model="form.password_confirmation"
        :error="formularyErrors.password_confirmation"
      />
      <BaseRadioGroup
        v-model="form.userType"
        :options="userTypesList"
        name="user_type"
      />
      <input type="submit" class="base_button button_primary" value="Cadastrar">
    </form>
  </section>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape({
  name: yup.string().required().min(3),
  nickname: yup.string().required().min(3),
  email: yup.string().required().email(),
  password: yup.string().required().min(6),
  password_confirmation: yup.string().required().min(6),
  userType: yup.number().required(),
});

export default {
  data() {
    return {
      form: {
        name: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: '',
        userType: '',
      },
      formularyErrors: {
        name: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: '',
        userType: '',
      },
      userTypesList: [
        { label: 'Nenhum', value: 1 },
        { label: 'Admin', value: 0 },
      ],
    };
  },
  methods: {
    sendForm() {
      schema.validate(this.form, { abortEarly: false })
        .then(() => {
          console.log('validou');
          axios.post('http://localhost:8000/api/user/register', this.form)
            .then((response) => {
              console.log(response);
            })
            .catch((error) => {
              console.log(error);
            });
        })
        .catch((err) => {
          console.log(err.inner);
          this.formularyErrors = {};
          err.inner.forEach((error) => {
            this.formularyErrors[error.path] = error.message;
          });
        });
    },
  },
};
</script>

<style scoped>
.base_form {
  align-items: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1rem;
  margin: 0 auto;
  max-width: 720px;
}
</style>
