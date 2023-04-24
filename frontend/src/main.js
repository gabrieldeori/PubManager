import upperFirst from 'lodash/upperFirst';
import camelCase from 'lodash/camelCase';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

const requireComponent = require.context(
  './components',
  false,
  /Base[A-Z]\w+\.(vue|js)$/,
);

const app = createApp(App).use(router);

requireComponent.keys().forEach((fileName) => {
  const componentConfig = requireComponent(fileName);

  const componentName = upperFirst(
    camelCase(fileName.replace(/^\.\/(.*)\.\w+$/, '$1')),
  );

  app.component(componentName, componentConfig.default || componentConfig);
});

app.mount('#app');
