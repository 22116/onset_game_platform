<template>
  <VueForm method="PATCH" action="/user/password" @onSuccess="onPasswordSuccess">
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input name="plainPassword[first]" type="password" class="form-control" id="pwd">
    </div>
    <div class="form-group">
      <label for="pwd">Repeat Password:</label>
      <input name="plainPassword[second]" type="password" class="form-control" id="rpwd">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </VueForm>
</template>

<script>
import VueForm from "@/components/VueForm";

export default {
  name: "PasswordForm",
  components: { VueForm },
  methods: {
    onPasswordSuccess: function() {
      this.$toasted.show("Password has been updated.");
    }
  }
};
</script>

<style scoped>
</style>
