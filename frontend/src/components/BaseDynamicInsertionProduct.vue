<template>
  <div>
    <p v-if="insertionList.length === 0">Insira ao menos um produto</p>
      <div>
        <div v-for="(insertion, index) in insertionList" :key="'key_insertion_' + index">

          <BasePreviewProduct
            v-if="editId !== index && insertion.product_id !== null"
            @click="editInsertion(index)"
            :preview="insertion"
            :products="responseProducts"
          />

          <div v-if="editId === index">
            <BaseSelectProducts
              v-model="toEdit.product_id"
              label='Produto'
              name='product'
              :options="responseProducts"
              :required="true"
            />
            <BaseInput
              v-model="toEdit.price"
              label='Preço individual'
              type='number'
              placeholder='Apenas números'
              :required="true"
              @input="calculateTotalPrice"
            />
            <BaseInput
              v-model="toEdit.quantity"
              label='Quantidade'
              type='number'
              placeholder='Apenas números'
              :required="true"
              @input="calculateBoth"
            />
            <BaseInput
              v-model="toEdit.total_price"
              label='Preço Total'
              type='number'
              placeholder='Apenas números'
              :required="true"
              @input="calculateIndividualPrice"
            />
          </div>

          <BaseEditButtons
            v-show="editId === index"
            @deleteEmit="deleteInsertion(index)"
            @cancelEmit="cancelInsertion(index)"
            @saveEmit="saveInsertion(index)"
          />

        </div>
      </div>
      <!-- Nova inserção, pode ser no pai -->
      <button
        class='base_button button_primary invert'
        @click.prevent="newInsertion"
      >
        + Adicionar outra linha
      </button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'BaseDynamicInsertion',
  data() {
    return {
      editId: -1,
      toEdit: {},
      responseProducts: [],
      insertionList: [],
    };
  },
  methods: {
    newInsertion() {
      this.editId = this.insertionList.length;
      this.toEdit = {
        name: '',
        product_id: null,
        price: 0,
        quantity: 0,
        total_price: 0,
      };
      this.insertionList.push({
        name: '',
        product_id: null,
        price: 0,
        quantity: 0,
        total_price: 0,
      });
    },
    editInsertion(index) {
      this.editId = index;
      this.toEdit = { ...this.insertionList[index] };
    },
    saveInsertion(index) {
      const {
        product_id: productId,
        price,
        quantity,
        total_price: totalPrice,
      } = this.toEdit;
      if (productId !== null && price > 0 && quantity > 0 && totalPrice > 0) {
        this.toEdit.price = parseFloat(price).toFixed(2);
        this.toEdit.total_price = parseFloat(totalPrice).toFixed(2);
        this.insertionList[index] = { ...this.toEdit };
        this.toEdit = {};
        this.editId = -1;
      }
    },
    cancelInsertion() {
      this.toEdit = {};
      this.editId = -1;
    },
    deleteInsertion(index) {
      this.insertionList.splice(index, 1);
      this.toEdit = {};
      this.editId = -1;
    },
    getProductsList() {
      axios.get(`${process.env.VUE_APP_ROOT_API}/products/show`)
        .then((response) => {
          const { products } = response.data.payload;
          const threated = products.map((product) => ({
            name: product.nome,
            id: product.id,
          }));
          this.responseProducts = threated;
        })
        .catch(({ response }) => {
          this.errors.title = response.data.message;
          this.errors.generic = response.data.payload.errors.generic;
          this.errors.specific = response.data.payload.errors.specific;
          this.errors.validation = response.data.payload.errors.validation;
        });
    },
    calculateTotalPrice() {
      const { price, quantity } = this.toEdit;
      if (quantity > 0 && price > 0) {
        this.toEdit.total_price = (price * quantity).toFixed(4);
      } else {
        this.toEdit.total_price = 0;
      }
    },
    calculateIndividualPrice() {
      const { total_price: totalPrice, quantity } = this.toEdit;
      if (quantity > 0 && totalPrice > 0) {
        this.toEdit.price = (totalPrice / quantity).toFixed(4);
      } else {
        this.toEdit.price = 0;
      }
    },
    calculateBoth() {
      const { total_price: totalPrice, quantity } = this.toEdit;
      if (quantity > 0 && totalPrice > 0) {
        this.calculateIndividualPrice();
      } else {
        this.calculateTotalPrice();
      }
    },
  },
  mounted() {
    this.getProductsList();
  },
};
</script>
