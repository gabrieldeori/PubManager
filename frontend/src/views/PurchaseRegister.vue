<template>
  <form submit.prevent="">
    <BaseErrors
      :errors="errors"
    />
    <section>
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
      <!-- produtos -->
      <ul v-if="form.products.length > 0">
        <article
          v-for="(product, pIndex) in form.products"
          v-bind="product"
          :key="'product_key_id_' + product.id"
        >
          <button
            v-if="editId !== pIndex && responseProducts.length > 0"
            class="base_button button_primary_lighter"
            @click="editInsertion(pIndex)"
          >
            {{ responseProducts[product.id - 1].name }}
            - R${{ product.individualPrice }}
            x{{ product.quantity }}
            = R${{ product.totalPrice }}
          </button>
          <div v-if="editId === pIndex" class="product_form">
            <BaseSelectProducts
              name="products"
              label="Produto"
              v-model="productForm.id"
              :options="responseProducts"
              :error="formularyErrors.id"
            />
            <p v-if="formularyErrors.id" class="error_message">
              {{ formularyErrors.id }}
            </p>
            <BaseInput
              name="quantity"
              label="Quantidade"
              placeholder="Apenas números"
              type="number"
              v-model="productForm.quantity"
              :error="formularyErrors.quantity"
              @input="calculateTotalPrice"
            />
            <BaseInput
              name="individualPrice"
              label="Preço individual"
              placeholder="Apenas números"
              type="number"
              v-model="productForm.individualPrice"
              :error="formularyErrors.individualPrice"
              @input="calculateTotalPrice"
            />
            <BaseInput
              name="totalPrice"
              label="Preço Total"
              placeholder="Apenas números"
              type="number"
              v-model="productForm.totalPrice"
              :error="formularyErrors.totalPrice"
              @input="calculateIndividualPrice"
            />
            <BaseEditButtons
              @deleteEmit="deleteInsertion(pIndex)"
              @cancelEmit="cancelInsertion(pIndex)"
              @saveEmit="saveInsertion(pIndex)"
            />
          </div>
        </article>
      </ul>
    </section>

    <button
      class='base_button button_primary invert'
      v-if="form.products.length > 0 && !blockEditClick"
      @click.prevent="newInsertion"
    >
      + Adicionar outro produto
    </button>
    <button
      class='base_button button_primary invert'
      v-else-if="!blockEditClick"
      @click.prevent="newInsertion"
    >
      + Adicionar produto
    </button>

    <p>
      Quantidade de produtos: {{ form.products.length }}
      Total: R$ {{ totalPrice }}
    </p>

    <p v-if="formularyErrors.products" class="error_message">
      {{ formularyErrors.products }}
    </p>

    <BaseEditButtons
        v-if="!blockEditClick"
        :notDelete="true"
        txtCancel="Voltar"
        value="Cadastrar"
        @cancelEmit="this.$router.push('/purchases/show')"
        @saveEmit="sendForm"
      />
  </form>
</template>

<script>
import axios from 'axios';
import * as yup from '@/helpers/yupbrasil';

const schema = yup.object().shape({
  name: yup.string().required().min(3).max(255),
  description: yup.string().nullable(),
  products: yup.array().of(
    yup.object().shape({
      id: yup.number().required(),
      individualPrice: yup.number().required(),
      quantity: yup.number().required(),
      totalPrice: yup.number().required(),
    }),
  ).min(1),
});

export default {
  name: 'PurchaseRegister',
  data() {
    return {
      form: {
        name: '',
        description: '',
        products: [],
      },

      productForm: {
        id: '',
        individualPrice: '',
        quantity: '',
        totalPrice: '',
      },

      editId: null,
      blockEditClick: false,
      responseProducts: [],
      formularyErrors: {},
      errors: {},
      totalSomado: 0,
    };
  },
  methods: {
    async sendForm() {
      try {
        this.formularyErrors = {};
        this.errors = {};
        await schema.validate(this.form, { abortEarly: false });
        await axios.post(`${process.env.VUE_APP_ROOT_API}/api/purchase/register`, this.form);
        this.$router.push({ name: 'PurchasesShow' });
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

    async getProducts() {
      try {
        const response = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/products/options`);
        this.responseProducts = response.data.payload.products;
      } catch (errors) {
        const { response } = errors;
        if (!response) {
          this.errors.generic = errors.message;
        }
        this.errors.title = response.data.message || '';
        this.errors.generic = response.data.payload.errors.generic || '';
        this.errors.specific = response.data.payload.errors.specific || '';
        this.errors.validation = response.data.payload.errors.validation || '';
      }
    },

    newInsertion() {
      if (this.blockEditClick) return;
      this.editId = this.form.products.length;
      this.productForm = {
        id: 0,
        individualPrice: '',
        quantity: '',
        totalPrice: '',
      };
      this.form.products.push({ ...this.productForm });
      this.blockEditClick = true;
    },

    validateInsertion() {
      const {
        id, individualPrice, quantity, totalPrice,
      } = this.productForm;

      const errors = [];

      if (id <= 0) {
        errors.push({
          name: 'id',
          message: 'O campo produto é obrigatório',
        });
      }
      if (!individualPrice || individualPrice <= 0) {
        errors.push({
          name: 'individualPrice',
          message: 'O campo preço individual é obrigatório',
        });
      }
      if (!quantity || quantity <= 0) {
        errors.push({
          name: 'quantity',
          message: 'O campo quantidade é obrigatório',
        });
      }
      if (!totalPrice || totalPrice <= 0) {
        errors.push({
          name: 'totalPrice',
          message: 'O campo preço total é obrigatório',
        });
      }
      if (errors.length > 0) {
        return errors;
      }
      return false;
    },

    normalizeValues() {
      const {
        id, individualPrice, quantity, totalPrice,
      } = this.productForm;

      this.productForm.id = parseInt(id, 10);
      this.productForm.individualPrice = parseFloat(individualPrice).toFixed(2);
      this.productForm.quantity = parseFloat(quantity).toFixed(2);
      this.productForm.totalPrice = parseFloat(totalPrice).toFixed(2);
    },

    saveInsertion(index) {
      const isInvalid = this.validateInsertion();
      if (isInvalid) {
        isInvalid.forEach(({ name, message }) => {
          this.formularyErrors[name] = message;
        });
        return;
      }
      this.normalizeValues();
      this.form.products[index] = this.productForm;
      this.editId = null;
      this.productForm = {
        id: 0,
        individualPrice: '',
        quantity: '',
        totalPrice: '',
      };
      this.formularyErrors = {};
      this.errors = {};
      this.blockEditClick = false;
    },

    editInsertion(index) {
      if (this.blockEditClick) return;
      this.editId = index;
      this.productForm = {
        id: 0,
        individualPrice: '',
        quantity: '',
        totalPrice: '',
      };
      this.formularyErrors = {};
      this.errors = {};
      this.productForm = { ...this.form.products[index] };
      this.blockEditClick = true;
    },

    cancelInsertion(index) {
      this.form.products.splice(index, 1);
      this.editId = null;
      this.productForm = {
        id: 0,
        individualPrice: '',
        quantity: '',
        totalPrice: '',
      };
      this.formularyErrors = {};
      this.errors = {};
      this.blockEditClick = false;
    },

    deleteInsertion(index) {
      this.form.products.splice(index, 1);
      this.productForm = {
        id: 0,
        individualPrice: '',
        quantity: '',
        totalPrice: '',
      };
      this.editId = null;
      this.formularyErrors = {};
      this.errors = {};
      this.blockEditClick = false;
    },

    calculateTotalPrice() {
      const { individualPrice, quantity } = this.productForm;
      if (quantity > 0 && individualPrice > 0) {
        this.productForm.totalPrice = (individualPrice * quantity).toFixed(4);
      } else {
        this.productForm.totalPrice = 0;
      }
    },

    calculateIndividualPrice() {
      const { totalPrice, quantity } = this.productForm;
      if (quantity > 0 && totalPrice > 0) {
        this.productForm.individualPrice = (totalPrice / quantity).toFixed(4);
      } else {
        this.productForm.individualPrice = 0;
      }
    },
  },

  computed: {
    totalPrice() {
      const total = this.form.products
        .reduce((acc, { totalPrice }) => {
          if (!totalPrice) return acc;
          return acc + parseFloat(totalPrice);
        }, 0);
      return total.toFixed(2);
    },
  },

  mounted() {
    this.getProducts();
  },
};
</script>

<style scoped>
.error_message {
  color: var(--danger_stronger);
  padding: 0.25rem;
}

.product_form {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.product_form input {
  width: 100%;
  margin: 0.5rem 0;
}

.product_form button {
  margin: 0.5rem 0;
}

.product_form button:first-child {
  margin-top: 1rem;
}

.product_form button:last-child {
  margin-bottom: 1rem;
}
</style>
```
