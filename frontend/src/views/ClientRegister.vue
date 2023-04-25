<template>
  <form @submit.prevent="">
    <h1>FORM</h1>
    <BaseInput
      v-show="creating || editing"
      v-model="form.name"
      label='Nome'
      type='text'
      placeholder='Apenas letras e espaços'
      required
    />
  </form>
  <div
    v-for="client in clientArray"
    v-bind:key="'key_' + client.id"
    v-show="!editing"
  >
    {{ client.id }} - {{ client.name }} |
    <button
      @click="editClient(client)"
    >
      edit
    </button>
  </div>

  <!-- Novo Cliente -->
  <button
    v-show="!creating && !editing"
    class='base_button button_primary invert'
    @click="newClient"
  >
    + Adicionar outro cliente
  </button>

  <button
    v-show="creating || editing"
    class='base_button button_primary invert'
    @click="addClient"
  >
    Registrar Cliente
  </button>

  <button
    v-show="creating || editing"
    class='base_button button_danger invert'
    @click="cancel"
  >
    Cancelar
  </button>

  <!-- Enviar -->
  <button
    v-show="!creating && !editing"
    class='base_button button_primary'
    @click="sendClients"
  >
    Enviar Clientes
  </button>
  <h1>Preview</h1>
  <pre>
    creating: {{ creating }}
    editing: {{ editing }}
    editId: {{ editId }}
    clients: {{ clientArray }}
    form: {{ form }}
  </pre>
</template>

<script>
// import axios from 'axios';

export default {
  name: 'ClientRegister',

  data() {
    return {
      creating: false,
      editing: false,
      editId: null,
      form: {
        name: '',
      },
      clientArray: [],
    };
  },
  methods: {
    newClient() {
      this.creating = true;
      this.editing = false;
    },
    addClient() {
      if (this.editId != null) {
        this.clientArray[this.editId].name = this.form.name;
      } else {
        this.clientArray.push({
          id: this.clientArray.length,
          name: this.form.name,
        });
      }
      this.creating = false;
      this.editing = false;
      this.form.name = '';
      this.editId = null;
    },
    editClient(client) {
      this.creating = false;
      this.editing = true;
      this.form.name = client.name;
      this.editId = client.id;
    },
    sendClients() {
      console.log(this.clientArray);
    },
    cancel() {
      this.creating = false;
      this.editing = false;
      this.form.name = '';
      this.editId = null;
    },
  },
};
</script>
