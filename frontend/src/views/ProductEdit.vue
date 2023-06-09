<template>
  <section>
    <form class="base_form" @submit.prevent="sendForm">
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
        value="Cadastrar"
        @deleteEmit="deleteProduct"
        @cancelEmit="cancelProduct"
        @saveEmit="sendForm"
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
  name: 'ProductEdit',

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
        alcoholic: false,
        preparable: false,
      },

      errors: {},
    };
  },

  methods: {
    async getUser() {
      try {
        const payload = { id: this.$route.params.id };
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/product`, { params: payload });
        this.form = data.payload.product;
        this.form.alcoholic = data.payload.product.alcoholic === 'Sim';
        this.form.preparable = data.payload.product.preparable === 'Sim';
      } catch (errors) {
        const { response } = errors;
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
      }
    },

    async sendForm() {
      try {
        await schema.validate(this.form, { abortEarly: false });
        await axios.put(`${process.env.VUE_APP_ROOT_API}/product/edit`, this.form);
        this.$router.push('/products/show');
      } catch (errors) {
        if (errors instanceof yup.ValidationError) {
          errors.inner.forEach((e) => {
            this.formularyErrors[e.path] = e.message;
          });
        } else {
          const { response } = errors;
          this.errors.title = response.data.message || '';
          this.errors.generic = response.data.payload.errors.generic || '';
          this.errors.specific = response.data.payload.errors.specific || '';
          this.errors.validation = response.data.payload.errors.validation || '';
        }
      }
    },

    async deleteProduct() {
      try {
        const { id } = this.$route.params;
        await axios.delete(`${process.env.VUE_APP_ROOT_API}/product/delete`, { params: { id } });
        this.$router.push('/products/show');
      } catch (errors) {
        const { response } = errors;
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
        if (this.errors.generic.includes('Integrity constraint violation')) {
          this.errors.generic = 'Não é possível excluir um produto que já foi utilizado em um pedido';
        }
      }
    },

    cancelProduct() {
      this.$router.push('/products/show');
    },
  },

  mounted() {
    this.getUser();
  },
};
</script>
