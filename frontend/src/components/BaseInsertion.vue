<template>
  <div class="insert_area">
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
    <div>
      <!-- Novo Cliente -->
      <button
        v-show="!creating && !editing"
        class='base_button button_primary invert'
        @click="newInsertion"
      >
        + Adicionar outro cliente
      </button>
      <button
        v-show="creating || editing"
        class='base_button button_primary invert'
        @click="addInsertion"
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
    </div>
  </div>

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

export default {
  name: 'BaseInsertion',
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
    newInsertion() {
      this.creating = true;
      this.editing = false;
    },
    addInsertion() {
      if (this.editId != null) {
        this.clientArray[this.editId].name = this.form.name;
      } else {
        this.clientArray.push({
          id: this.clientArray.length,
          name: this.form.name,
        });
      }

      this.$emit('update:clients', this.clientArray);

      this.creating = false;
      this.editing = false;
      this.form.name = '';
      this.editId = null;
    },
    editInsertion(client) {
      this.creating = false;
      this.editing = true;
      this.form.name = client.name;
      this.editId = client.id;
    },
    deleteInsertion(client) {
      this.clientArray.splice(client.id, 1);
    },
    cancel() {
      this.creating = false;
      this.editing = false;
      this.form.name = '';
      this.editId = null;
    },
  },
  emits: ['update:clients'],
};
</script>
