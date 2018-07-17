<template>
  <div class="row justify-content-center">
    <form v-if="!showSuccessAlert" @submit.prevent="submit">
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input v-model="password" type="password" class="form-control" id="pwd">
      </div>
      <div class="form-group">
        <label for="pwd">Repeat Password:</label>
        <input v-model="passwordRepeat" type="password" class="form-control" id="rpwd">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div v-if="showSuccessAlert">
      <p>Your password was successfully changed.</p>
    </div>
  </div>
</template>

<script>
import { apiJoin } from "../utils/path";

export default {
  name: "ResettingConfirmed",
  data() {
    return {
      showSuccessAlert: false,
      password: null,
      passwordRepeat: null,
      confirmToken: this.$route.params.confirmationToken
    };
  },
  methods: {
    submit: function() {
      let that = this;
      this.axios
        .patch(apiJoin("/auth/resetting/confirm"), {
          data: {
            plainPassword: {
              first: this.password,
              second: this.passwordRepeat
            }
          },
          token: this.confirmToken
        })
        .then(() => (that.showSuccessAlert = true));
    }
  }
};
</script>

<style scoped>
</style>
