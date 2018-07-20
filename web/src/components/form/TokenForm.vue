<template>
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
