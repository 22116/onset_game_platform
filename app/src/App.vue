<template>
  <div id="app" class="container-fluid p-0">
    <b-row id="nav" class="m-0">
      <b-col cols="12">
        <router-link to="/">Home</router-link> |
        <router-link to="/records">Records</router-link> |
        <template v-if="!$auth.check()">
          <router-link  to="/login">Login</router-link> |
          <router-link  to="/register">Sign Up</router-link>
        </template>
        <template v-else>
          <router-link to="/settings">Settings</router-link> |
          <a v-if="$auth.check()" href="/" @click.prevent="$auth.logout()">Logout</a>
        </template>
      </b-col>
    </b-row>
    <b-row v-if="$auth.ready()" class="m-0">
      <b-col cols="12" class="p-0">
        <router-view></router-view>
      </b-col>
    </b-row>
    <b-row v-if="!$auth.ready()" class="m-0">
      <b-col>
        <div class="loader m-auto"></div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  mounted: function() {
    this.$auth.user();
  }
};
</script>

<style lang="scss">
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
  a {
    font-weight: bold;
    color: #2c3e50;
    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
