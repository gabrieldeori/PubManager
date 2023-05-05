<template>
  <div>
    <div v-for="(insertion, index) in insertionList" :key="'key_insertion_' + index">

      <!-- Preview Area -->
      <BasePreview v-if="editId !== index" @click="editInsertion(index)" :preview="insertion"/>

      <!-- Edit Area Diferente pra cada Register -->
      <div v-if="editId === index">
        <BaseInput
          v-model="toEdit.name"
          label='Nome'
          type='text'
          placeholder='Apenas letras e espaços'
          required
        />
      </div>

      <div v-show="editId === index" class="flex_horizontal">
        <BaseEditButtons
          @deleteEmit="deleteInsertion(index)"
          @cancelEmit="cancelInsertion()"
          @saveEmit="saveInsertion(index)"
        />
      </div>
    </div>
  </div>

  <!-- Nova inserção, pode ser no pai -->
  <button
      class='base_button button_primary invert'
      @click="newInsertion"
    >
      + Adicionar outra linha
    </button>
</template>

<script>
export default {
  name: 'BaseDynamicInsertion',
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
      this.toEdit = { name: '' };
      this.insertionList.push({ name: '' });
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
  },
};
</script>
