<template>
  <section>
    <form @submit.prevent="">
      <h2>Registrar Cliente</h2>
      <p v-if="insertionList.length === 0">Nenhum cliente</p>
      <BaseErrors :errors="this.errors" />
      <div>
        <div v-for="(insertion, index) in insertionList" :key="'key_insertion_' + index">

          <BasePreview
            v-if="editId !== index && !blockEditClick"
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
            saveTxt="Salvar Cliente"
            v-show="editId === index"
            @deleteEmit="deleteInsertion(index)"
            @cancelEmit="cancelInsertion(index)"
            @saveEmit="saveInsertion(index)"
          />

        </div>
      </div>
      <button
      v-if="insertionList.length > 0 && !blockEditClick"
      type="button"
      class='base_button button_primary invert'
      @click="newInsertion">
        + Adicionar outro cliente
      </button>
      <button
      v-else-if="!blockEditClick"
      type="button"
      class='base_button button_primary invert'
      @click="newInsertion">
        + Adicionar cliente
      </button>

      <BaseEditButtons
        v-if="!blockEditClick"
        :notDelete="true"
        cancelTxt="Voltar"
        saveTxt="Cadastrar Clientes"
        value="Cadastrar"
        @cancelEmit="this.$router.push('/clients/show')"
        @saveEmit="saveEvent"
      />
    </form>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ClientRegister',
  data() {
    return {
      blockEditClick: false,
      editId: null,
      insertionList: [],
      toEdit: {},
      errors: {},
    };
  },

  methods: {
    newInsertion() {
      this.blockEditClick = true;
      this.editId = this.insertionList.length;
      this.toEdit = {
        name: '',
      };
      this.insertionList.push({
        name: '',
      });
    },

    editInsertion(index) {
      this.blockEditClick = true;
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
      this.editId = null;
      this.blockEditClick = false;
    },

    cancelInsertion(index) {
      if (this.insertionList[index].name === '') {
        this.insertionList.splice(index, 1);
      }
      this.blockEditClick = false;
      this.editId = null;
      this.toEdit = {};
    },

    deleteInsertion(index) {
      this.insertionList.splice(index, 1);
      this.editId = null;
      this.toEdit = {};
    },

    async saveEvent() {
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

          await axios.post(`${process.env.VUE_APP_ROOT_API}/client/register`, this.insertionList);
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
