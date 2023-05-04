<template>
  <section>
    <form @submit.prevent="SubmitClients">
      <h1>Registrar Compra</h1>
      <BaseErrors :errors="errors" />
      <BaseDynamicInsertionProduct
        v-model="insertionList"
      />
      <button class='base_button button_primary' type="submit">
        Enviar
      </button>
    </form>
  </section>
</template>

<script>
import axios from 'axios';
import yup from '@/helpers/yupbrasil';

export default {
  name: 'PurchaseRegister',
  data() {
    return {
      editId: -1,
      insertionList: [],
      toEdit: {},
      formularyErrors: {
        name: '',
        description: '',
        products: '',
      },
    };
  },
  methods: {
    newInsertion() {
      this.editId = this.insertionList.length;
      this.toEdit = {
        name: '',
      };
      this.insertionList.push({
        name: '',
      });
    },

    editInsertion(index) {
      this.editId = index;
      this.toEdit = { ...this.insertionList[index] };
    },

    saveInsertion(index) {
      if (this.toEdit.name === '') {
        window.alert('Insira um nome válido');
        return;
      }
      this.insertionList[index] = { ...this.toEdit };
      this.toEdit = {};
      this.editId = -1;
    },

    cancelInsertion(index) {
      if (this.insertionList[index].name === '') {
        this.insertionList.splice(index, 1);
        this.toEdit = {};
        this.editId = -1;
        return;
      }
      this.toEdit = {};
      this.editId = -1;
    },

    deleteInsertion(index) {
      this.insertionList.splice(index, 1);
      this.toEdit = {};
      this.editId = -1;
    },
    invalidNameOnArray() {
      return this.insertionList.some((insertion) => insertion.name === '');
    },
    async SubmitClients() {
      if (this.insertionList.length > 0 && !this.invalidNameOnArray()) {
        const confirmed = window.confirm('Tem certeza que deseja salvar?');
        if (confirmed) {
          try {
            await axios.post('http://localhost:8000/api/purchase/register', this.insertionList);
            this.$router.push('/purchases/show');
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
      }
    },
    registerPurchase() {
      axios.post('http://localhost:8000/api/purchase/register', this.form)
        .then(() => {
          this.$router.push('/purchases/show');
        })
        .catch(({ response }) => {
          this.formularyErrors.name = response.data.payload.errors.name || '';
          this.formularyErrors.description = response.data.payload.errors.description || '';
          this.formularyErrors.alcoholic = response.data.payload.errors.alcoholic || '';
          this.formularyErrors.preparable = response.data.payload.errors.preparable || '';
        });
    },
  },
};
</script>
