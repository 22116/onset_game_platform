<template>
  <div class="row justify-content-center">
    <form v-if="!showSuccessAlert" @submit.prevent="submit">
      <div class="form-group">
        <label for="email">Email address:</label>
        <input name="username" v-model="email" type="email" class="form-control" id="email">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div v-if="showSuccessAlert">
      <p>If the email you typed matches yours, you will receive a message which contains a link you must click to reset your password.</p>
      <p>Note: You can only request a new password once within 2 hours.</p>
      <p>If you don't get an email check your spam folder or try again.</p>
    </div>
  </div>
</template>

<script>
import { apiJoin } from "../utils/path";

export default {
  name: "Resetting",
  data() {
    return {
      email: null,
      showSuccessAlert: false
    }
  },
  methods: {
    submit: function() {
      let that = this;
      this.axios.post(apiJoin("/auth/resetting"), {
        email: this.email
      })
      .then(() => that.showSuccessAlert = true);
    }
  }
}
</script>

<style scoped>

</style>