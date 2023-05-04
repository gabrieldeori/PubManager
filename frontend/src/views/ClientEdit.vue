<template>
  <section>
    <h1>Editar Cliente</h1>

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

      <button
        class="base_button button_primary"
        @click="editClient()"
        >
          Atualizar
      </button>
      <button
        class="base_button button_danger invert"
        @click="this.$router.push(`/clients/show`)"
      >
        Cancelar
      </button>
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
        const { data } = await axios.get('http://localhost:8000/api/client', { params: payload });
        this.form = data.payload.client;
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
    async editClient() {
      const confirmed = window.confirm('Deseja realmente atualizar este cliente?');
      if (confirmed) {
        try {
          await schema.validate(this.form, { abortEarly: false });
          const payload = { ...this.form };
          await axios.put('http://localhost:8000/api/client/edit', payload);
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
  },
  mounted() {
    this.getClient();
  },
};
</script>
