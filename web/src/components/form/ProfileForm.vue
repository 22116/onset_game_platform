<template>
  <VueForm method="PATCH" action="/profiles" @onSuccess="onProfileSuccess">
    <b-form-group label="First name:" lavel-for="fname">
      <b-form-input name="firstName" type="text" id="fname" v-model="profile.firstName" />
    </b-form-group>
    <b-form-group label="Last name:" lavel-for="lname">
      <b-form-input name="lastName" type="text" id="lname" v-model="profile.lastName" />
    </b-form-group>
    <b-form-group label="Facebook URL:" lavel-for="profile-fburl">
      <b-form-input name="facebookUrl" type="text" id="profile-fburl" v-model="profile.facebookUrl" />
    </b-form-group>
    <b-form-group label="Description:" lavel-for="profile-description">
      <b-form-textarea name="description" id="profile-description" v-model="profile.description" placeholder="Enter something" />
    </b-form-group>
    <b-button type="submit" variant="primary">Submit</b-button>
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
