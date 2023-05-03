<template>
  <section>
    <h1>Editar Usuário</h1>

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
      label="Nova senha"
      placeholder="(Opcional) Mínimo 6 caracteres"
      type="password"
      v-model="form.password"
      :error="formularyErrors.password"
    />
    <BaseInput
      name="password_confirmation"
      label="Nova confirmação de senha"
      placeholder="(Opcional se trocar senha) Repita a senha"
      type="password"
      v-model="form.password_confirmation"
      :error="formularyErrors.password_confirmation"
    />
    <BaseInput
      name="password_old"
      label="Senha atual"
      placeholder="Digite a senha atual"
      type="password"
      v-model="form.password_old"
      :error="formularyErrors.password_old"
    />
    <BaseRadioGroup
      v-model="form.userType"
      :options="userTypesList"
      name="user_type"
      :error="formularyErrors.userType"
    />

    <button
      class="base_button button_primary"
      @click="editUser()"
      >
        Atualizar
    </button>
    <button
      class="base_button button_danger invert"
      @click="this.$router.push(`/users/show`)"
    >
      Cancelar
    </button>
  </section>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape(
  {
    name: yup.string().required().min(3).max(255)
      .matches(/^[a-zA-ZÀ-ÿ\s]+$/, 'Apenas letras e espaços em branco'),
    nickname: yup.string().required().min(3).max(45)
      .matches(/^[a-zA-Z]+$/, 'Apenas letras'),
    email: yup.string().required().email(),
    userType: yup.string().required().oneOf(['Nenhum', 'Admin']),
    password_old: yup.string().required().min(6).max(255),
    password: yup.string().nullable().notRequired().when(
      'password',
      {
        is: (val) => !!(val && val.length > 0),
        then: (rule) => rule.min(6).max(255),
      },
    ),
    password_confirmation: yup.string().oneOf([yup.ref('password'), null], 'As senhas devem ser iguais'),
  },
  ['password', 'password'],
);

export default {
  name: 'ClientEdit',
  data() {
    return {
      toEdit: null,
      errorData: null,
      form: {
        name: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: '',
        password_old: '',
        userType: 'Nenhum',
      },
      formularyErrors: {
        name: '',
        nickname: '',
        email: '',
        password: '',
        password_confirmation: '',
        password_old: '',
        userType: '',
      },
      userTypesList: [
        { label: 'Nenhum', value: 'Nenhum' },
        { label: 'Admin', value: 'Admin' },
      ],
    };
  },
  methods: {
    getUser() {
      const payload = { id: this.$route.params.id };
      axios.get('http://localhost:8000/api/user', { params: payload })
        .then((response) => {
          this.toEdit = response.data.payload.user;
          this.form = {
            ...payload,
            name: this.toEdit.name,
            nickname: this.toEdit.nickname,
            email: this.toEdit.email,
            password: '',
            password_confirmation: '',
            userType: this.toEdit.userType,
          };
        })
        .catch((err) => {
          console.error(err.response);
          window.alert('Erro ao buscar usuário');
        });
    },
    async editUser() {
      const confirmed = window.confirm('Deseja realmente atualizar este cliente?');
      if (confirmed) {
        schema.validate(this.form, { abortEarly: false })
          .then(() => {
            axios.put('http://localhost:8000/api/user/edit', this.form)
              .then(() => {
                window.alert('Usuário Atualizado com sucesso!');
                this.$router.push('/users/show');
              })
              .catch((err) => {
                console.error(err.response);
                window.alert('Erro ao atualizar usuário');
              });
          })
          .catch((err) => {
            this.formularyErrors = {
              name: '',
              nickname: '',
              email: '',
              password: '',
              password_confirmation: '',
              userType: '',
            };
            err.inner.forEach((error) => {
              this.formularyErrors[error.path] = error.message;
            });
          });
      }
    },
  },
  mounted() {
    this.getUser();
  },
};
</script>
