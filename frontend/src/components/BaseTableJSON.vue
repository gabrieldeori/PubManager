<template>
  <table class="table_field">
    <caption>{{ table_title }}</caption>
    <thead>
      <tr>
        <th
          v-for="tHeadData, thdi in Object.keys(getHeadersForTable())"
          v-bind:key="'key_tHeadData_' + thdi"
        >
          {{ tHeadData }}
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
          {{ tBodyData }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: 'BaseTableJSON',
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
  },
};
</script>
