<template>
  <section>
    <h1>Compras</h1>

    <BaseErrors :errors="errors" />

    <BaseTableJSON
      :table_title="'Compras'"
      :table_data="responseCashRegister"
      :is_crud="true"
      @updateEmit="updateRegister"
      @deleteEmit="deleteRegister"
    />
  </section>
</template>

<script>
import axios from 'axios';
import BaseTableJSON from '@/components/BaseTableJSON.vue';

export default {
  name: 'CashRegistersShow',
  data() {
    return {
      errors: {},
      responseCashRegister: [],
    };
  },
  components: {
    BaseTableJSON,
  },
  methods: {
    async getCashRegister() {
      try {
        const { data } = await axios.get('http://localhost:8000/api/cashregister/show');
        this.responseCashRegister = data.payload.cashRegisters;
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
    },
    async deleteRegister(id) {
      const confirmed = window.confirm(`Tem certeza que deseja deletar o id ${id}?`);
      if (confirmed) {
        try {
          // Depende
          await axios.delete('http://localhost:8000/api/purchase/delete', { data: { id } });
          // await axios.delete('http://localhost:8000/api/comanda/delete', { data: { id } });
          alert('Compra deletada com sucesso!');
          this.$router.go();
        } catch (errors) {
          const { response } = errors;
          if (!response) {
            this.errors.generic = errors.message;
            return;
          }
          this.errors.title = response.data.message;
          this.errors.generic = response.data.payload.errors.generic || '';
          this.errors.specific = response.data.payload.errors.specific || '';
          this.errors.validation = response.data.payload.errors.validation || '';
        }
      }
    },
    updateRegister(id) {
      // Depende
      this.$router.push(`/purchase/${id}`);
      // this.$router.push(`/comanda/${id}`);
    },
  },
  mounted() {
    this.getCashRegister();
  },
};
</script>
