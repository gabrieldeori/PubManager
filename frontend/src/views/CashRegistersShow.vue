<template>
  <section>
    <h2>Fluxo de Caixa</h2>

    <BaseErrors :errors="errors" />

    <BaseTableJson
      :table_title="'Compras'"
      :table_data="responseCashRegister"
      @updateEmit="updateRegister"
    />
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CashRegistersShow',
  data() {
    return {
      errors: {},
      responseCashRegister: [],
    };
  },
  methods: {
    async getCashRegister() {
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/cashregister/show`);
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
    updateRegister({ idComanda, idCompra }) {
      if (idComanda) {
        this.$router.push(`/comanda/${idComanda}`);
      } else if (idCompra) {
        this.$router.push(`/purchase/${idCompra}`);
      }
    },
  },
  mounted() {
    this.getCashRegister();
  },
};
</script>
