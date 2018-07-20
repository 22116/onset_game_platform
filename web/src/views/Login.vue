<template>
    <div class="container">
        <div v-if="confirmStatus === true" class="alert alert-success">
            Email was confirmed. You can login now.
        </div>
        <div v-if="confirmStatus === false" class="alert alert-danger">
            There are no users attached to this account. Please try <router-link to="/register">Sign Up</router-link> again.
        </div>
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
import { apiJoin } from "../utils/path";

export default {
  name: "Login",
  data() {
    return {
      confirmStatus: null,
      email: null,
      password: null,
      rememberMe: false,
      showError: false
    };
  },
  mounted: function() {
    let that = this;
    let token = this.$route.params.confirmationToken;
    if (undefined !== token) {
      this.axios
        .post(apiJoin("/auth/register/confirm"), {
          token: token
        })
        .then(() => (that.confirmStatus = true))
        .catch(() => (that.confirmStatus = false));
    }
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
