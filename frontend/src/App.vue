<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link> |
    <router-link to="/palette">Palette</router-link>
  </nav>
  <router-view/>
</template>

<style>
:root {
  /* Base */
  --black: black;
  --smooth_black: #0E0E0E;
  --grey_1: #5B5B5B;
  --grey_2: #BEBEBE;
  --smooth_white: #E0E0E0;
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
}

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
</style>
