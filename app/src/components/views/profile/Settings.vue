<template>
  <div class="container">
    <b-card no-body>
      <b-card-body class="p-0">
        <b-tabs card lazy>
          <b-tab title="Personal data" id="profile" active>
            <profile-form :profile="profile" />
          </b-tab>
          <b-tab id="account" title="Account settings">
            <b-row>
              <b-col>
                <b-card title="Change email" class="text-center">
                  <email-form :email="email" />
                </b-card>
              </b-col>
              <b-col>
                <b-card title="Change password" class="text-center">
                  <password-form />
                </b-card>
              </b-col>
            </b-row>
          </b-tab>
        </b-tabs>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import EmailForm from "@/components/form/EmailForm";
import PasswordForm from "@/components/form/PasswordForm";
import ProfileForm from "@/components/form/ProfileForm";

export default {
  name: "Settings",
  components: {
    EmailForm,
    PasswordForm,
    ProfileForm
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
    }
  }
};
</script>

<style scoped>
</style>
