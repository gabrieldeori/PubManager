<template>
  <nav>
    <BasePubDropDown :dropsMenus="dropsMenus"/>
  </nav>
  <router-view/>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css';

export default {
  name: 'App',
  data() {
    return {
      dropsMenus: [
        {
          group: 'Produtos',
          options: [
            {
              id: 'showProducts',
              title: 'Ver Produtos',
              link: '/products/show',
            },
            {
              id: 'registerProducts',
              title: 'Criar Produto',
              link: '/product/register',
            },
          ],
        },
        {
          group: 'Compras',
          options: [
            {
              id: 'showPurchases',
              title: 'Ver Compras',
              link: '/purchases/show',
            },
            {
              id: 'registerPurchases',
              title: 'Registrar Compra',
              link: '/purchase/register',
            },
          ],
        },
        {
          group: 'Comandas',
          options: [
            {
              id: 'showComandas',
              title: 'Ver Comandas',
              link: '/comandas/show',
            },
            {
              id: 'registerComandas',
              title: 'Registrar Comanda',
              link: '/comanda/register',
            },
          ],
        },
        {
          group: 'Caixa',
          options: [
            {
              id: 'showComandas',
              title: 'Ver Fluxo de Caixa',
              link: '/cashregisters/show',
            },
            {
              id: 'showDashBoard',
              title: 'DashBoard',
              link: '/dashboard',
            },
          ],
        },
        {
          group: 'Clientes',
          options: [
            {
              id: 'showClients',
              title: 'Ver Clientes',
              link: '/clients/show',
            },
            {
              id: 'registerClients',
              title: 'Registrar Cliente',
              link: '/client/register',
            },
          ],
        },
        {
          group: 'Usuários',
          options: [
            {
              id: 'showUsers',
              title: 'Ver Usuários',
              link: '/users/show',
            },
            {
              id: 'registerUsers',
              title: 'Registrar Usuário',
              link: '/user/register',
            },
          ],
        },
        {
          group: 'Login',
          options: [
            {
              id: 'login',
              title: 'Login',
              link: '/login',
            },
            {
              id: 'logout',
              title: 'Logout',
              link: '/logout',
            },
          ],
        },
      ],
    };
  },
};
</script>

<style>
:root {
  /* Base */
  --black: black;
  --smooth_black: #0E0E0E;
  --grey_0: #3a3a3a;
  --grey_1: #4d4d4d;
  --grey_2: #7c7c7c;
  --smooth_white: #eeeeee;
  --white: white;

  /* Primary */
  --primary_darker: #4D2007;
  --primary_dark: #9D410E;
  --primary_stronger: #FF6914;
  --primary_strong: #F18E32;
  --primary_light: #F4A760;
  --primary_lighter: #FFE2C7;
  --primary_white: #FAEAE1;

  /* Highlight */
  --highlight_darker: #001C45;
  --highlight_dark: #0042A6;
  --highlight_stronger: #0066FF;
  --highlight_strong: #4B93FF;
  --highlight_light: #8DBBFF;
  --highlight_lighter: #C1DAFF;
  --highlight_white: #DFECFF;

  /* Danger */
  --danger_darker: #460B03;
  --danger_dark: #8A1809;
  --danger_stronger: #FF1F00;
  --danger_strong: #EB432C;
  --danger_light: #FF6B57;
  --danger_lighter: #FFAA9E;
  --danger_white: #FFD8D2;

  /* Success */
  --success_darker: #005806;
  --success_dark: #047700;
  --success_stronger: #00ad00;
  --success_strong: #00c500;
  --success_light: #6eff6e;
  --success_lighter: #c7ffc7;
  --success_white: #d9ffd9;
}

body {
  background-color: var(--primary_white);
  color: var(--smooth_black);
  font-family: 'Roboto', sans-serif;
  font-size: 16px;
  margin: 0;
  padding: 0;
}

/* Input Defaults */
.input_label {
  align-items: flex-start;
  border: none;
  color: var(--smooth_black);
  display: flex;
  flex-flow: column;
  font-size: 1rem;
  justify-content: center;
  margin-bottom: 0.25rem;
  max-width: 100%;
  padding: 0.5rem;
  width: fit-content;
}

.input_label_text {
  margin-left: 0.5rem;
}

.input_label_side {
  align-items: center;
  border: none;
  color: var(--smooth_black);
  cursor: pointer;
  display: flex;
  flex-flow: row wrap;
  font-size: 1rem;
  justify-content: flex-start;
  margin-bottom: 0.25rem;
  max-width: 100%;
  padding: 0.5rem;
  width: fit-content;
}

.input_label_side_text {
  font-size: 1rem;
  margin-left: 0.25rem;
}

/* ***** */
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}

section {
  align-items: center;
  display: flex;
  flex-flow: column;
  justify-content: center;
}

select {
  font-size: 1.2rem;
  padding: 0.25rem 0.75rem;
}

/* Forms */

form {
  align-items: center;
  display: flex;
  flex-flow: column;
  justify-content: center;
  gap: 1rem;
  width: 100%;
}

/* SPECIAL */
.flex_horizontal {
  align-items: center;
  display: flex;
  flex-flow: row wrap;
  justify-content: center;
  gap: 0.2rem;
}

.flex_vertical {
  align-items: center;
  display: flex;
  flex-flow: column;
  justify-content: center;
  gap: 1rem;
}

/* Buttons */
/* Base */
.base_button {
  background-color: var(--black);
  border: 0.1rem solid var(--black);
  border-radius: 0.3rem;
  color: var(--white);
  display: flex;
  gap: 1rem;
  font-size: 1rem;
  padding: 0.3rem 1rem;
}

.button_black {
  background-color: var(--black);
  border-color: var(--black);
  color: var(--white);
}

.button_black:hover {
  background-color: var(--grey_2);
  border-color: var(--grey_1);
  color: var(--grey2);
}

.button_black:focus {
  background-color: var(--smooth_black);
  border-color: var(--grey_0);
  color: var(--grey1);
}

.button_black.invert {
  background-color: var(--white);
  border-color: var(--black);
  color: var(--black);
}

.button_black.invert:hover {
  background-color: var(--smooth_black);
  border-color: var(--grey_0);
  color: var(--grey2);
}

.button_black.invert:focus {
  background-color: var(--grey_2);
  border-color: var(--grey_1);
  color: var(--grey2);
}

/* primary */
.button_primary {
  background-color: var(--primary_stronger);
  border-color: var(--primary_stronger);
  color: var(--primary_white);
}

.button_primary:hover {
  background-color: var(--primary_strong);
  border-color: var(--primary_stronger);
  color: var(--primary_lighter);
}

.button_primary:focus {
  background-color: var(--primary_lighter);
  border-color: var(--primary_stronger);
  color: var(--primary_strong);
}

.button_primary.invert {
  background-color: var(--primary_white);
  border-color: var(--primary_stronger);
  color: var(--primary_stronger);
}

.button_primary.invert:hover {
  background-color: var(--primary_lighter);
  border-color: var(--primary_stronger);
  color: var(--primary_strong);
}

.button_primary.invert:focus {
  background-color: var(--primary_strong);
  border-color: var(--primary_stronger);
  color: var(--primary_lighter);
}

/* primary lighter*/
.button_primary_lighter {
  background-color: var(--primary_lighter);
  border-color: var(--primary_strong);
  color: var(--primary_strong);
}

.button_primary_lighter:hover {
  background-color: var(--primary_light);
  border-color: var(--primary_darker);
  color: var(--primary_darker);
}

.button_primary_lighter:focus {
  background-color: var(--primary_stronger);
  border-color: var(--primary_white);
  color: var(--primary_wite);
}

/* highlight */
.button_highlight {
  background-color: var(--highlight_stronger);
  border-color: var(--highlight_stronger);
  color: var(--highlight_white);
}

.button_highlight:hover {
  background-color: var(--highlight_strong);
  border-color: var(--highlight_stronger);
  color: var(--highlight_lighter);
}

.button_highlight:focus {
  background-color: var(--highlight_lighter);
  border-color: var(--highlight_stronger);
  color: var(--highlight_strong);
}

.button_highlight.invert {
  background-color: var(--highlight_white);
  border-color: var(--highlight_stronger);
  color: var(--highlight_stronger);
}

.button_highlight.invert:hover {
  background-color: var(--highlight_lighter);
  border-color: var(--highlight_stronger);
  color: var(--highlight_strong);
}

.button_highlight.invert:focus {
  background-color: var(--highlight_strong);
  border-color: var(--highlight_stronger);
  color: var(--highlight_lighter);
}

/* danger */
.button_danger {
  background-color: var(--danger_stronger);
  border-color: var(--danger_stronger);
  color: var(--danger_white);
}

.button_danger:hover {
  background-color: var(--danger_strong);
  border-color: var(--danger_stronger);
  color: var(--danger_lighter);
}

.button_danger:focus {
  background-color: var(--danger_lighter);
  border-color: var(--danger_stronger);
  color: var(--danger_strong);
}

.button_danger.invert {
  background-color: var(--danger_white);
  border-color: var(--danger_stronger);
  color: var(--danger_stronger);
}

.button_danger.invert:hover {
  background-color: var(--danger_lighter);
  border-color: var(--danger_stronger);
  color: var(--danger_strong);
}

.button_danger.invert:focus {
  background-color: var(--danger_strong);
  border-color: var(--danger_stronger);
  color: var(--danger_lighter);
}

.base_button {
  align-items: center;
  background-clip: padding-box;
  border: 1px solid transparent;
  border-radius: .25rem;
  box-shadow: rgba(0, 0, 0, 0.02) 0 1px 3px 0;
  box-sizing: border-box;
  cursor: pointer;
  display: inline-flex;
  font-family: system-ui,-apple-system,system-ui,"Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 16px;
  font-weight: 600;
  justify-content: center;
  line-height: 1.25;
  margin: 0;
  min-height: 3rem;
  padding: calc(.875rem - 1px) calc(1.5rem - 1px);
  position: relative;
  text-decoration: none;
  transition: all 250ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  width: auto;
}

.base_button:hover,
.base_button:focus {
  box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
}

.base_button:hover {
  transform: translateY(-1px);
}

.base_button:active {
  box-shadow: rgba(0, 0, 0, .06) 0 2px 4px;
  transform: translateY(0);
}

.product_form {
  border-top: 0.1rem solid var(--primary_dark);
  border-bottom: 0.1rem solid var(--primary_dark);
  padding: 1rem 0;
  margin: 1rem 0;
}
</style>
