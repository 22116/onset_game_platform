<template>
  <div class="home">
    <img src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    <p>JWT: {{jwt}}</p>
    <p>Username: {{jwtUsername}}</p>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import HelloWorld from "@/components/HelloWorld.vue";

export default {
  name: "home",
  components: {
    HelloWorld
  },
  computed: {
    ...mapGetters(["jwt", "jwtUsername"])
  },
  methods: {
    ...mapActions([`fetchJWT`]),

    async doSomethingWithJWT() {
      // const res = await fetch(`http://localhost/vuejs-jwt-example/do-something`, {
      //     method: 'POST',
      //     headers: new Headers({
      //         Authorization: `Bearer: ${this.jwt}`
      //     })
      // });
      // Do stuff with res here.
    }
  },

  mounted() {
    this.fetchJWT({
      username: "22116",
      password: "degkjm"
    });
  }
};
</script>
