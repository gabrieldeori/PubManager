<template>
  <section>
    <form @submit.prevent="SubmitClients">
      <h1>Registrar Cliente</h1>
      <p v-if="insertionList.length === 0">Insira ao menos um cliente</p>
      <BaseErrors :errors="this.errors" />
      <div>
        <div v-for="(insertion, index) in insertionList" :key="'key_insertion_' + index">

          <BasePreview
            v-if="editId !== index"
            @click="editInsertion(index)"
            :preview="insertion"
            />

          <div v-if="editId === index">
            <BaseInput
              v-model="toEdit.name"
              label='Nome'
              type='text'
              placeholder='Apenas letras e espaços'
              :required="true"
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
      <button
      v-if="insertionList.length > 0"
      type="button"
      class='base_button button_primary invert'
      @click="newInsertion">
        + Adicionar outro cliente
      </button>
      <button
      v-else
      type="button"
      class='base_button button_primary invert'
      @click="newInsertion">
        + Adicionar cliente
      </button>
      <button class='base_button button_primary' type="submit">
        Enviar
      </button>
    </form>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientRegister',
  data() {
    return {
      editId: -1,
      insertionList: [],
      toEdit: {},
      errors: {},
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
    async SubmitClients() {
      const confirmed = window.confirm('Tem certeza que deseja salvar?');
      if (confirmed) {
        try {
          if (this.insertionList.length === 0) {
            throw new Error('Insira ao menos um cliente');
          }
          this.insertionList.forEach((element) => {
            if (element.name === '') {
              throw new Error('Insira um nome válido');
            }

            const validateRegex = /^[a-zA-ZÀ-ÿ\s]+$/;
            if (!validateRegex.test(element.name)) {
              throw new Error('Apenas letras e espaços em branco');
            }
          });

          await axios.post(`${process.env.VUE_APP_ROOT_API}/api/client/register`, this.insertionList);
          this.$router.push('/clients/show');
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
      }
    },
  },
};
</script>
