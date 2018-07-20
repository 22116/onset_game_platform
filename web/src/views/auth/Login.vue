<template>
    <div class="container">
        <div v-if="showError" class="alert alert-danger">
            Invalid credentials
        </div>
        <div class="row justify-content-center">
            <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input name="username" v-model="email" type="email" class="form-control" id="email">
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
                <router-link to="/resetting">Forgot password?</router-link>
                <button type="submit" class="btn btn-primary ml-2">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      email: null,
      password: null,
      rememberMe: false,
      showError: false
    };
  },
  methods: {
    submit: function() {
      let that = this;
      this.$auth
        .login({
          data: { username: this.email, password: this.password },
          rememberMe: this.rememberMe
        })
        .catch(function() {
          that.showError = true;
        });
    }
  }
};
</script>

<style scoped>
</style>
