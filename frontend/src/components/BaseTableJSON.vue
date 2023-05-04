<template>
  <div class="table_wrapper">
    <table class="table_field" v-if="table_data.length > 0">
      <caption>{{ table_title }}</caption>
      <thead>
        <tr>
          <th
            v-for="tHeadData, thindex in Object.keys(getHeadersForTable())"
            v-bind:key="'key_tHeadData_' + thindex"
          >
            {{ tHeadData }}
          </th>
          <th v-if="is_crud">
            Atualizar
          </th>
          <th v-if="is_crud">
            Deletar
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="tBodyRow, tbri in table_data"
          v-bind:key="'key_tBodyRow_' + tbri"
        >
          <td
            v-for="tBodyData, tbdi in Object.values(tBodyRow)"
            v-bind:key="'key_tBodyData_' + tbdi"
          >
            <ul v-if="Array.isArray(tBodyData)">
              <li
                v-for="tBodyDataItem, tbdii in tBodyData.slice(0,5)"
                v-bind:key="'key_tBodyDataItem_' + tbdii"
              >
                {{ tBodyDataItem }}
              </li>
              ...
            </ul>
            <div v-else>{{ tBodyData }}</div>
          </td>
          <td v-if="is_crud">
            <button
              class="base_button button_highlight invert"
              @click="updateEmit(tBodyRow.id)"
              >
                <img src="../assets/icons/icon_edit.svg" alt="">
              </button>
          </td>
          <td v-if="is_crud">
            <button
              class="base_button button_danger"
              @click="deleteEmit(tBodyRow.id)"
            >
              <img src="../assets/icons/icon_delete.svg" alt="">
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'BaseTableJSON',
  props: {
    is_crud: {
      type: Boolean,
      default: false,
    },
    table_title: {
      type: String,
      default: 'Título da tabela',
    },
    table_data: {
      type: Array,
      default: () => ([
        {
          id: 1,
          name: 'dummy_name1',
          email: 'dummy1@mail.dum',
          phone: 'dummy1_phone',
        },
        {
          id: 2,
          name: 'dummy_name2',
          email: 'dummy2@mail.dum',
          phone: 'dummy2_phone',
          teste: 'dummy2_phone',
        },
        {
          id: 3,
          name: 'dummy_name3',
          email: 'dummy3@mail.dum',
          phone: 'dummy3_phone',
        },
      ]),
    },
  },
  methods: {
    getHeadersForTable() {
      return this.table_data.reduce(
        (acc, curr) => {
          if (Object.keys(curr).length > Object.keys(acc).length) {
            return curr;
          }
          return acc;
        },
        {},
      );
    },
    updateEmit(id) {
      this.$emit('updateEmit', id);
    },
    deleteEmit(id) {
      this.$emit('deleteEmit', id);
    },
  },
};
</script>

<style scoped>
caption {
  font-size: 1rem;
  font-weight: bold;
  background-color: var(--primary_lighter);
  border: 0.1rem solid var(--primary_strong);
  border-bottom: 0;
}

img {
  max-width: 2rem;
  max-height: 2rem;
}

button {
  align-items: center;
  display: flex;
  justify-content: center;
  margin: 0;
  padding: 0.25rem;
  width: 100%;
  height: 3rem;
  max-height: 3rem;
  max-width: 100%;
}

li {
  text-align: left;
}
</style>
