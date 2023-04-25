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
      />
      <BaseInput
        name="nickname"
        label="Nome de usuário"
        placeholder="Apenas letras"
        type="text"
        v-model="form.nickname"
      />
      <BaseInput
        name="email"
        label="E-mail"
        placeholder="Digite seu e-mail"
        type="email"
        v-model="form.email"
      />
      <BaseInput
        name="password"
        label="Senha"
        placeholder="Mínimo 6 caracteres"
        type="password"
        v-model="form.password"
      />
      <BaseInput
        name="password_confirmation"
        label="Confirmação de senha"
        placeholder="Repita a senha"
        type="password"
        v-model="form.password_confirmation"
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
      userTypesList: [
        { label: 'Nenhum', value: 1 },
        { label: 'Admin', value: 0 },
      ],
    };
  },
  methods: {
    sendForm() {
      axios.post('http://127.0.0.1:8000/register', this.event)
        .then((response) => {
          console.log('Response: ', response);
        })
        .catch((error) => {
          console.log('Error: ', error);
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
