<template>
  <section>
    <h2>Editar Cliente</h2>

    <BaseErrors :errors="errors" />

    <div v-if="form !== null">
      <h3>{{ form.id }} - {{ form.name }}</h3>

      <BaseInput
        v-model="form.name"
        label='Nome'
        type='text'
        placeholder='Apenas letras e espaços'
        required
        :error="formularyErrors.name"
      />

      <p>Criado em: {{ form.created_at }}</p>
      <p>Atualizado em: {{ form.updated_at }}</p>

      <BaseEditButtons
        @saveEmit="sendForm"
        @deleteEmit="deleteClient"
        @cancelEmit="this.$router.push('/clients/show')"
      />
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape({
  name: yup.string().required().min(3).max(255)
    .matches(/^[a-zA-ZÀ-ÿ\s]+$/, 'Apenas letras e espaços em branco'),
});

export default {
  name: 'ClientEdit',
  data() {
    return {
      form: {
        name: '',
      },
      formularyErrors: {
        name: '',
      },
      errors: {},
    };
  },
  methods: {
    async getClient() {
      const payload = { id: this.$route.params.id };
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/client`, { params: payload });
        this.form = data.payload.client;
      } catch (errors) {
        if (errors instanceof yup.ValidationError) {
          errors.inner.forEach((e) => {
            this.formularyErrors[e.path] = e.message;
          });
        }
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
    async sendForm() {
      const confirmed = window.confirm('Deseja realmente atualizar este cliente?');
      if (confirmed) {
        try {
          await schema.validate(this.form, { abortEarly: false });
          const payload = { ...this.form };
          await axios.put(`${process.env.VUE_APP_ROOT_API}/client/edit`, payload);
          this.$router.push('/clients/show');
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
            this.errors.title = response.data.message || '';
            this.errors.generic = response.data.payload.errors.generic || '';
            this.errors.specific = response.data.payload.errors.specific || '';
            this.errors.validation = response.data.payload.errors.validation || '';
          }
        }
      }
    },
    async deleteClient() {
      const { id } = this.$route.params;
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          await axios.delete(`${process.env.VUE_APP_ROOT_API}/client/delete`, { data: { id } });
          alert('Cliente deletado com sucesso!');
          this.$router.push('/clients/show');
        } catch (errors) {
          console.log(errors);
          const { response } = errors;
          if (!response) {
            this.errors.title = errors.message;
            this.errors.generic = 'Veja se o servidor está ligado';
            return;
          }
          this.errors.title = response.data.message || '';
          this.errors.generic = response.data.payload.errors.generic || '';
          this.errors.specific = response.data.payload.errors.specific || '';
          this.errors.validation = response.data.payload.errors.validation || '';
          if (this.errors.generic.includes('Integrity constraint violation:')) {
            this.errors
              .generic = 'Este cliente talvez possua outros registros e não pode ser deletado';
          }
        }
      }
    },
  },
  mounted() {
    this.getClient();
  },
};
</script>
