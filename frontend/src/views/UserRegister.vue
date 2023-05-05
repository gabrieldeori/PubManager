<template>
  <section>
    <h2>form</h2>
    <BaseErrors :errors="errors" />
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
        :error="formularyErrors.userType"
      />
      <BaseEditButtons
        v-if="!blockEditClick"
        :notDelete="true"
        txtCancel="Voltar"
        value="Cadastrar"
        @cancelEmit="this.$router.push('/users/show')"
        @saveEmit="sendForm"
      />
    </form>
  </section>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape({
  name: yup.string().required().min(3).max(255)
    .matches(/^[a-zA-ZÀ-ÿ\s]+$/, 'Apenas letras e espaços em branco'),
  nickname: yup.string().required().min(3).max(45)
    .matches(/^[a-zA-Z]+$/, 'Apenas letras'),
  email: yup.string().required().email(),
  password: yup.string().required().min(6).max(255),
  password_confirmation: yup.string().required().oneOf([yup.ref('password')]),
  userType: yup.string().required().oneOf(['Nenhum', 'Admin']),
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
        userType: 'Nenhum',
      },
      formularyErrors: {
        name: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: '',
        userType: '',
      },
      errors: {},
      userTypesList: [
        { label: 'Nenhum', value: 'Nenhum' },
        { label: 'Admin', value: 'Admin' },
      ],
    };
  },
  methods: {
    async sendForm() {
      try {
        await schema.validate(this.form, { abortEarly: false });
        await axios.post(`${process.env.VUE_APP_ROOT_API}/api/user/register`, this.form);
        window.alert('Usuário registrado com sucesso!');
        this.$router.push('/users/show');
      } catch (errors) {
        if (errors instanceof yup.ValidationError) {
          errors.inner.forEach((e) => {
            this.formularyErrors[e.path] = e.message;
          });
        } else {
          const { response } = errors;
          if (!response.data.payload.errors && !response.data.payload && !response) {
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
