<template>
  <VueForm method="PATCH" action="/users/password" @onSuccess="onPasswordSuccess">
    <b-form-group label="Password:" label-for="pwd">
      <b-form-input id="pwd" type="password" name="plainPassword[first]" placeholder="*********" />
    </b-form-group>
    <b-form-group label="Repeat Password:" label-for="rpwd">
      <b-form-input id="rpwd" type="password" name="plainPassword[second]" placeholder="*********" />
    </b-form-group>
    <b-button type="submit" variant="primary">Submit</b-button>
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
