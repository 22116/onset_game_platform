<template>
  <div class="row justify-content-center">
    <VueForm v-if="!isAlertShown" method="POST" action="/auth/resetting" @onSuccess="showSuccessAlert">
      <div class="form-group">
        <label for="email">Email address:</label>
        <input name="email" type="email" class="form-control" id="email">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </VueForm>
    <div v-if="isAlertShown">
      <p>If the email you typed matches yours, you will receive a message which contains a link you must click to reset your password.</p>
      <p>Note: You can only request a new password once within 2 hours.</p>
      <p>If you don't get an email check your spam folder or try again.</p>
    </div>
  </div>
</template>

<script>
import VueForm from "../components/VueForm";

export default {
  name: "Resetting",
  components: { VueForm },
  data() {
    return {
      email: null,
      isAlertShown: false
    };
  },
  methods: {
    showSuccessAlert: function () {
      this.isAlertShown = true;
    }
  }
};
</script>

<style scoped>
</style>
