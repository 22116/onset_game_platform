<template>
  <div class="row justify-content-center">
    <VueForm v-if="!isAlertShown" action="/auth/resetting/confirm" method="PATCH" data-prefix="data" @onSuccess="showSuccessAlert">
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input name="data[plainPassword][first]" type="password" class="form-control" id="pwd">
      </div>
      <div class="form-group">
        <label for="pwd">Repeat Password:</label>
        <input name="data[plainPassword][second]" type="password" class="form-control" id="rpwd">
      </div>
      <input type="hidden" name="token" :value="confirmToken" />
      <button type="submit" class="btn btn-primary">Submit</button>
    </VueForm>
    <div v-if="isAlertShown">
      <p>Your password was successfully changed.</p>
    </div>
  </div>
</template>

<script>
import VueForm from "../components/VueForm";

export default {
  name: "ResettingConfirmed",
  components: { VueForm },
  data() {
    return {
      isAlertShown: false,
      confirmToken: this.$route.params.confirmationToken
    };
  },
  methods: {
    showSuccessAlert: function() {
      this.isAlertShown = true;
    }
  }
};
</script>

<style scoped>
</style>
