<template>
  <table class="table_field">
    <caption>{{ data.title }}</caption>
    <thead>
      <tr
        v-for="tHeadRow, thri in data.cabecalho"
        v-bind:key="'key_tHeadRow_' + thri"
      >
        <th
          v-for="tHeadData, thdi in tHeadRow"
          v-bind:key="'key_tHeadData_' + thdi"
        >
          {{ tHeadData }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="tBodyRow, tbri in data.corpo"
        v-bind:key="'key_tBodyRow_' + tbri"
      >
        <td
          v-for="tBodyData, tbdi in tBodyRow"
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
  name: 'BaseTable',
  props: {
    data: {
      type: Object,
      default: () => ({
        title: 'Título da tabela',
        cabecalho: [
          [
            'th1',
            'th2',
            'th3',
          ],
          [
            'th1',
            'th2',
            'th3',
          ],
        ],
        corpo: [
          [
            'td1',
            'td2',
            'td3',
          ],
          [
            'td1',
            'td2',
            'td3',
          ],
          [
            'td1',
            'td2',
            'td3',
          ],
        ],
      }),
    },
  },
};
</script>
