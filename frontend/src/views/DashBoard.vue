<template>
  <div>
    <h1>Dashboard</h1>
    <p>Total Income: {{ dashboard.total_income }}</p>
    <p>Total Outcome: {{ dashboard.total_outcome }}</p>
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
    };
  },
  methods: {
    async getDashboard() {
      try {
        const { data } = await axios.get(`${process.env.VUE_APP_ROOT_API}/api/dashboard`);
        const {
          total_income: totalIncome,
          total_outcome: totalOutcome,
        } = data.payload.dashboard;

        this.dashboard = { totalIncome, totalOutcome };
      } catch (errors) {
        const { response } = errors;
        if (!response.data.payload.errors && !response.data.payload && !response) {
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
