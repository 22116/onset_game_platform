<template>
  <div class="home">
    <img src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
</template>
<script>
import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "home",
  components: {
    HelloWorld
  },
  mounted: function() {
    this.$auth
      .login({
        data: { username: "testUser", password: "test123" },
        rememberMe: true
      })
      .catch(error => console.log(error.response))
      .then(() => {
        // console.log(this.$auth.user());
      });
  }
};
</script>
