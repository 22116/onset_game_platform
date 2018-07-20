<template>
  <VueForm method="POST" action="/user/email" @onSuccess="onEmailSuccess">
    <div class="form-group">
      <label for="email">Email:</label>
      <input name="tempEmail" type="text" class="form-control" id="email" :value="email" />
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </VueForm>
</template>

<script>
import VueForm from "@/components/VueForm";

export default {
  name: "EmailForm",
  components: { VueForm },
  props: {
    email: { type: String, required: true }
  },
  methods: {
    onEmailSuccess: function() {
      this.$toasted.show("Email has been updated.");
    }
  }
};
</script>

<style scoped>
</style>
