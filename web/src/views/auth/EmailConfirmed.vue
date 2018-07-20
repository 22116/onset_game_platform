<template>
  <div class="container">
    <div v-if="confirmStatus === true" class="alert alert-success">
      Email was confirmed. You can <router-link to="/login">login</router-link> now.
    </div>
    <div v-if="confirmStatus === false" class="alert alert-danger">
      There are no users attached to this account. Please try <router-link to="/register">Sign Up</router-link> again.
    </div>
  </div>
</template>

<script>
import { apiJoin } from "../../utils/path";

export default {
  name: "EmailConfirmed",
  data() {
    return {
      confirmStatus: null
    };
  },
  mounted: function() {
    let that = this;
    let token = this.$route.params.confirmationToken;

    this.axios
      .post(apiJoin("/auth/register/confirm"), {
        token: token
      })
      .then(function() {
        that.confirmStatus = true;
        if (that.$auth.check()) {
          that.$auth.logout();
        }
      })
      .catch(() => (that.confirmStatus = false));
  }
};
</script>

<style scoped>
</style>
