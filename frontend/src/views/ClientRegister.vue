<template>
  <section>
    <form @submit.prevent="SubmitClients">
      <h1>Registrar Cliente</h1>
      <p v-if="insertionList.length === 0">Insira ao menos um cliente</p>
      <div>
        <div v-for="(insertion, index) in insertionList" :key="'key_insertion_' + index">

          <BasePreview v-if="editId !== index" @click="editInsertion(index)" :preview="insertion" />

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

      <button type="button" class='base_button button_primary invert' @click="newInsertion">
        + Adicionar outra linha
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
    SubmitClients() {
      if (this.insertionList.length > 0 && !this.invalidNameOnArray()) {
        const confirmed = window.confirm('Tem certeza que deseja salvar?');
        if (confirmed) {
          axios.post('http://localhost:8000/api/client/register', this.insertionList)
            .then((res) => {
              window.alert('Clientes registrados com sucesso!');
              this.$router.push('/clients/show');
              console.log(res);
            })
            .catch((err) => {
              console.error(err);
              window.alert('Erro ao registrar clientes');
            });
        }
      } else {
        window.alert('Insira clientes válidos');
      }
    },
  },
};
</script>
