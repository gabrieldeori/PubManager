<template>
  <div>
    <BaseErrors :errors="errors" />
    <h1>Dashboard</h1>
    <p>Total Income: R$ {{ dashboard.totalIncome }}</p>
    <p>Total Outcome: R$ {{ dashboard.totalOutcome }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'DashBoard',
  data() {
    return {
      dashboard: {
        totalIncome: 0,
        totalOutcome: 0,
      },
      errors: {},
    };
  },
  methods: {
    async getDashboard() {
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/dashboard`);
        const {
          total_income: totalIncome,
          total_outcome: totalOutcome,
        } = data.payload.dashboard;

        this.dashboard = { totalIncome, totalOutcome };
        console.log(this.dashboard);
      } catch (errors) {
        console.log(errors);
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
  },
  mounted() {
    this.getDashboard();
  },
};
</script>
