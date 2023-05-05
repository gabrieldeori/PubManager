<template>
  <div class="table-responsive table_wrapper">
    <table class="table" v-if="table_data.length > 0">
      <caption>{{ table_title }}</caption>
      <thead>
        <tr>
          <th
            v-for="tHeadData, thindex in Object.keys(getHeadersForTable())"
            v-bind:key="'key_tHeadData_' + thindex"
          >
            {{ tHeadData }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="tBodyRow, tbri in table_data"
          v-bind:key="'key_tBodyRow_' + tbri"
          @click="updateEmit(tBodyRow.id)"
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
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'BaseTableJson',
  props: {
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
    async updateEmit(id) {
      const toUpdate = this.table_data.find((item) => item.id === id);
      this.$emit('updateEmit', toUpdate);
    },
  },
};
</script>

<style scoped>
table {
  background-color: white;
}

li {
  text-align: left;
}

/* Tables */
table {
  background-color: var(--smooth_white);
  border-top: 0.1rem solid var(--primary_stronger);
  border-bottom: 0.1rem solid var(--primary_stronger);
  border-collapse: collapse;
  width: fit-content;
}

.table_wrapper {
  max-width: 100%;
  overflow: scroll;
}

td {
  cursor: pointer;
}

tr:nth-child(odd) {
  background-color: var(--primary_lighter);
}

tr:nth-child(even) {
  background-color: var(--primary_light);
}

th {
  background-color: var(--primary_light);
}

tbody tr:hover {
  background-color: var(--highlight_white);
  border-top: 2px solid var(--primary_darker);
  border-bottom: 2px solid var(--primary_darker);
}

.table_wrapper {
  max-width: 100%;
  overflow: auto;
}

</style>
