<template>
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
</template>

<script>
import VueForm from "@/components/VueForm";

export default {
  name: "ProfileForm",
  components: { VueForm },
  props: {
    profile: { type: Object, required: true }
  },
  methods: {
    onProfileSuccess: function() {
      this.$toasted.show("Profile has been updated.");
    }
  }
};
</script>

<style scoped>
</style>
