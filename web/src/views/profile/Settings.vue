<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-header">Profile:</div>
        <div class="card-body">
          <VueForm method="PATCH" action="/profile/edit" @onSuccess="onProfileSuccess">
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
              <input name="facebookUrl" type="text" class="form-control" id="profile-fburl"  :value="profile.facebookUrl" />
            </div>
            <div class="form-group">
              <label for="profile-description">Description:</label>
              <textarea name="description" class="form-control" id="profile-description">{{ profile.description }}</textarea>
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
          <VueForm method="PATCH" action="/user/edit" @onSuccess="onEmailSuccess">
            <div class="form-group">
              <label for="email">Email:</label>
              <input name="firstName" type="text" class="form-control" id="email" :value="email" />
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
        email: this.$auth.user().email,
        profile: this.$auth.user().profile
      }
    },
    methods: {
      onProfileSuccess: function () {
        this.$toasted.show("Profile has been updated.");
      },
      onEmailSuccess: function () {
        this.$toasted.show("Email has been updated.");
      }
    }
  }
</script>

<style scoped>

</style>