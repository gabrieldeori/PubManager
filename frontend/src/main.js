import * as Bootstrap from 'bootstrap';

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

Object.keys(Bootstrap).forEach((componentKey) => {
  const component = Bootstrap[componentKey];
  if (typeof component === 'object' && 'name' in component) {
    app.component(component.name, component);
  }
});

app.mount('#app');
