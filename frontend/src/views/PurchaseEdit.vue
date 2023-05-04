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
            v-if="editId !== pIndex"
            class="base_button button_primary_lighter"
            @click="editInsertion(pIndex)"
          >
            R$ {{ responseProducts[product.id - 1].name }}
            -{{ product.individualPrice }}
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
              name="individualPrice"
              label="Preço individual"
              placeholder="Apenas números"
              type="number"
              v-model="productForm.individualPrice"
              :error="formularyErrors.individualPrice"
              @input="calculateTotalPrice"
            />
            <BaseInput
              name="quantity"
              label="Quantidade"
              placeholder="Apenas números"
              type="number"
              v-model="productForm.quantity"
              :error="formularyErrors.quantity"
              @input="calculateboth"
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

    <input
      @click.prevent="sendForm"
      v-if="!blockEditClick"
      type="submit"
      class="base_button button_primary"
      value="Cadastrar"
    />
    <pre>
      {{ form }}
    </pre>
  </form>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PurchaseEdit',
  data() {
    return {
      responsePurchase: {},
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
      responseProducts: [],
      formularyErrors: {
        name: '',
        description: '',
        products: '',
      },
      errors: {},
      editId: null,
      blockEditClick: false,
      totalPrice: 0,
    };
  },
  methods: {
    async getProducts() {
      try {
        const response = await axios.get('http://localhost:8000/api/products/options');
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

    async getAPurchase() {
      try {
        const { data } = await axios.get('http://localhost:8000/api/purchase');
        this.responsePurchase = data.payload.purchase;
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
  },
  mounted() {
    this.getProducts();
    this.getAPurchase();
  },
};
</script>
