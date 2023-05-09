<template>
  <section>
    <h2>Editar Usuário</h2>
    <BaseErrors :errors="errors" />
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
      name="password_old"
      label="(Obrigatória) Senha atual"
      placeholder="Digite a senha atual"
      type="password"
      v-model="form.password_old"
      :error="formularyErrors.password_old"
    />
    <BaseInput
      name="password"
      label="(Opcional) Nova senha"
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
    <BaseRadioGroup
      v-model="form.userType"
      :options="userTypesList"
      name="user_type"
      :error="formularyErrors.userType"
    />

    <BaseEditButtons
        v-if="!blockEditClick"
        cancelTxt="Cancelar"
        saveTxt="Atualizar usuário"
        value="Atualizar"
        @deleteEmit="deleteUser"
        @cancelEmit="this.$router.push('/users/show')"
        @saveEmit="editUser"
      />
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
      errors: {},
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
    async getUser() {
      const payload = { id: this.$route.params.id };
      try {
        const response = await axios.get(
          `${process.env.VUE_APP_ROOT_API}/user`,
          { params: payload, form: this.form },
        );
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
      } catch (errors) {
        const { response } = errors;
        if (!response) {
          this.errors.generic = errors.message;
          return;
        }
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
      }
    },
    async editUser() {
      const confirmed = window.confirm('Deseja realmente atualizar este cliente?');
      if (confirmed) {
        try {
          await schema.validate(this.form, { abortEarly: false });
          await axios.put(`${process.env.VUE_APP_ROOT_API}/user/edit`, this.form);
          window.alert('Usuário Atualizado com sucesso!');
          this.$router.push('/users/show');
        } catch (errors) {
          if (errors instanceof yup.ValidationError) {
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
      }
    },

    deleteUser() {
      const confirmed = window.confirm('Deseja realmente deletar este usuário?');
      const { id } = this.$route.params;
      if (confirmed) {
        try {
          axios.delete(`${process.env.VUE_APP_ROOT_API}/user/delete`, { params: { id } });
          window.alert('Usuário deletado com sucesso!');
          this.$router.push('/users/show');
        } catch (errors) {
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
  mounted() {
    this.getUser();
  },
};
</script>
