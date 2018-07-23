<template>
  <VueForm method="PATCH" action="/tokens" @onSuccess="onTokenSuccess">
    <b-form-group label="Website:" lavel-for="weburl">
      <b-form-input name="websiteUrl" type="url" id="weburl" v-model="token.websiteUrl" />
    </b-form-group>
    <b-form-group label="Facebook:" lavel-for="token-fburl">
      <b-form-input name="facebookUrl" type="url" id="token-fburl" v-model="token.facebookUrl" />
    </b-form-group>
    <b-form-group label="Description:" lavel-for="token-description">
      <b-form-textarea name="description" id="token-description" v-model="token.description" />
    </b-form-group>
    <b-button type="submit" variant="primary">Submit</b-button>
  </VueForm>
</template>

<script>
import VueForm from "@/components/VueForm";

export default {
  name: "TokenForm",
  components: { VueForm },
  props: {
    token: { type: Object, required: true }
  },
  methods: {
    onTokenSuccess: function() {
      this.$toasted.show("Token has been updated.");
    }
  }
};
</script>

<style scoped>
</style>
