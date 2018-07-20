<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">Profile:</div>
        <div class="card-body">
          <VueForm method="PATCH" action="/profile" @onSuccess="onProfileSuccess">
            <div class="form-group">
              <label for="fname">First name:</label>
              <input name="firstName" type="text" class="form-control" id="fname" :value="profile.firstName" />
            </div>
            <div class="form-group">
              <label for="lname">Last name:</label>
              <input name="lastName" type="text" class="form-control" id="lname" :value="profile.lastName" />
            </div>
            <div class="form-group">
              <label for="profile-fburl">Facebook URL:</label>
              <input name="facebookUrl" type="url" class="form-control" id="profile-fburl"  :value="profile.facebookUrl" />
            </div>
            <div class="form-group">
              <label for="profile-description">Description:</label>
              <textarea name="description" class="form-control" id="profile-description" v-model="profile.description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </VueForm>
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-3">
      <div class="card">
        <div class="card-header">Change email:</div>
        <div class="card-body">
          <VueForm method="POST" action="/user/email" @onSuccess="onEmailSuccess">
            <div class="form-group">
              <label for="email">Email:</label>
              <input name="tempEmail" type="text" class="form-control" id="email" :value="email" />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </VueForm>
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-3">
      <div class="card">
        <div class="card-header">Change password:</div>
        <div class="card-body">
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
        </div>
      </div>
    </div>
    <div v-if="token" class="row justify-content-center mt-3">
      <div class="card">
        <div class="card-header">Token:</div>
        <div class="card-body">
          <VueForm method="PATCH" action="/token" @onSuccess="onTokenSuccess">
            <div class="form-group">
              <label for="weburl">Website:</label>
              <input name="websiteUrl" type="url" class="form-control" id="weburl" :value="token.websiteUrl" />
            </div>
            <div class="form-group">
              <label for="token-fburl">Facebook:</label>
              <input name="facebookUrl" type="url" class="form-control" id="token-fburl" :value="token.facebookUrl" />
            </div>
            <div class="form-group">
              <label for="token-description">Description:</label>
              <textarea name="description" class="form-control" id="token-description" v-model="token.description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </VueForm>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueForm from "@/components/VueForm";

export default {
  name: "Settings",
  components: { VueForm },
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
  },
  methods: {
    onProfileSuccess: function() {
      this.$toasted.show("Profile has been updated.");
    },
    onEmailSuccess: function() {
      this.$toasted.show("Email has been updated.");
    },
    onPasswordSuccess: function() {
      this.$toasted.show("Password has been updated.");
    },
    onTokenSuccess: function() {
      this.$toasted.show("Token has been updated.");
    }
  }
};
</script>

<style scoped>
</style>
