<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">Profile:</div>
        <div class="card-body">
          <profile-form :profile="profile" />
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-3">
      <div class="card">
        <div class="card-header">Change email:</div>
        <div class="card-body">
          <email-form :email="email" />
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-3">
      <div class="card">
        <div class="card-header">Change password:</div>
        <div class="card-body">
          <password-form />
        </div>
      </div>
    </div>
    <div v-if="token" class="row justify-content-center mt-3">
      <div class="card">
        <div class="card-header">Token:</div>
        <div class="card-body">
          <token-form :token="token" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EmailForm from "@/components/form/EmailForm";
import PasswordForm from "@/components/form/PasswordForm";
import ProfileForm from "@/components/form/ProfileForm";
import TokenForm from "@/components/form/TokenForm";

export default {
  name: "Settings",
  components: {
    EmailForm,
    PasswordForm,
    ProfileForm,
    TokenForm
  },
  data() {
    return {
      user: this.$auth.user()
    };
  },
  computed: {
    email: function() {
      return this.user.email;
    },
    profile: function() {
      return this.user.profile;
    },
    token: function() {
      return this.profile.token;
    }
  }
};
</script>

<style scoped>
</style>
