<template>
  <section>
    <form class="base_form" @submit.prevent="">
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
        name="description"
        label="Descrição"
        placeholder="Apenas letras e espaços em branco"
        type="text"
        v-model="form.description"
        :error="formularyErrors.description"
      />
      <BaseCheckbox
        name="alcoholic"
        label="Alcoólico"
        v-model="form.alcoholic"
        :error="formularyErrors.alcoholic"
      />
      <BaseCheckbox
        name="preparable"
        label="Preparável"
        v-model="form.preparable"
        :error="formularyErrors.preparable"
      />
      <BaseEditButtons
        :notDelete="true"
        txtCancel="Voltar"
        value="Cadastrar"
        @cancelEmit="this.$router.push('/products/show')"
        @saveEmit="saveEvent"
      />
    </form>
  </section>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape({
  name: yup.string().required().min(3).max(255),
  description: yup.string().nullable(),
  alcoholic: yup.bool().required(),
  preparable: yup.bool().required(),
});

export default {
  name: 'ProductRegister',

  data() {
    return {
      form: {
        name: '',
        description: '',
        alcoholic: false,
        preparable: false,
      },

      formularyErrors: {
        name: '',
        description: '',
        alcoholic: '',
        preparable: '',
      },

      errors: {},
    };
  },

  methods: {
    async saveEvent() {
      try {
        await schema.validate(this.form, { abortEarly: false });
        await axios.post(`${process.env.VUE_APP_ROOT_API}/product/register`, this.form);
        this.$router.push('/products/show');
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
    },
  },
};
</script>
