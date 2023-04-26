<template>
  <section>
    <form @submit.prevent="SubmitClients">
      <h1>Registrar Cliente</h1>
      <div>
        <div v-for="(insertion, index) in insertionList" :key="'key_insertion_' + index">

          <BasePreview v-if="editId !== index" @click="editInsertion(index)" :preview="insertion" />

          <div v-if="editId === index">
            <BaseInput
              v-model="toEdit.name"
              label='Nome'
              type='text'
              placeholder='Apenas letras e espaços'
              required />
          </div>

          <div v-show="editId === index" class="flex_horizontal">
            <BaseEditButtons @deleteEmit="deleteInsertion(index)" @cancelEmit="cancelInsertion()"
              @saveEmit="saveInsertion(index)" />
          </div>
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
      this.insertionList[index] = { ...this.toEdit };
      this.toEdit = {};
      this.editId = -1;
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
    SubmitClients() {
      if (this.insertionList.length > 0) {
        const confirmed = window.confirm('Tem certeza que deseja salvar?');
        if (confirmed) {
          axios.post('http://localhost:8000/api/client/register', this.insertionList)
            .then(() => {
              window.alert('Clientes registrados com sucesso!');
              this.$router.push('/clients/show');
            })
            .catch((err) => {
              console.error(err);
              window.alert('Erro ao registrar clientes');
            });
        }
      } else {
        window.alert('Insira pelo menos um cliente');
      }
    },
  },
};
</script>
