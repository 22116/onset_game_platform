<template>
    <div class="container">
        <div class="row justify-content-center">
            <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input name="username" v-model="username" type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input name="password" v-model="password" type="password" class="form-control" id="pwd">
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input v-model="rememberMe" class="form-check-input" type="checkbox"> Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      username: null,
      password: null,
      rememberMe: false
    };
  },
  methods: {
    submit: function() {
      this.$auth.login({
        data: { username: this.username, password: this.password },
        rememberMe: this.rememberMe
      });
    }
  }
};
</script>

<style scoped>
</style>
