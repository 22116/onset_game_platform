<template>
    <div class="container">
        <div class="row justify-content-center">
            <form v-if="!showConfirm" @submit.prevent="submit">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input name="email" v-model="email" type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input v-model="password" type="password" class="form-control" id="pwd">
                </div>
                <div class="form-group">
                    <label for="pwd">Repeat Password:</label>
                    <input v-model="passwordRepeat" type="password" class="form-control" id="rpwd">
                </div>
                <vue-recaptcha :sitekey="sitekey" size="normal" type="checkbox" @verify="onVerify" @expired="onExpire">
                    <button type="submit" class="btn btn-primary mt-2 float-right" :disabled="!verified">Submit</button>
                </vue-recaptcha>
            </form>
            <div v-if="showConfirm">
                <p>An email has been sent to {{ email }}. It contains an activation link you must click to activate your account.</p>
                <p>Do not forget to check your spam folder</p>
            </div>
        </div>
    </div>
</template>

<script>
import VueRecaptcha from "vue-recaptcha";

export default {
  name: "SignUp",
  components: {
    VueRecaptcha
  },
  data() {
    return {
      verified: false,
      sitekey: process.env.RECAPTCHA_SITEKEY,
      showConfirm: false,
      email: null,
      password: null,
      passwordRepeat: null,
      rememberMe: false,
      recaptchaResponse: null
    };
  },
  methods: {
    submit: function() {
      let that = this;
      this.$auth
        .register({
          data: {
            email: this.email,
            plainPassword: {
              first: this.password,
              second: this.passwordRepeat
            },
            "g-recaptcha-response": this.recaptchaResponse
          },
          rememberMe: this.rememberMe,
          redirect: false
        })
        .then(function(req) {
          if (req.status === 200) that.showConfirm = true;
        })
        .catch(function(req) {
          //TODO: validation parser component/module
        });
    },
    onVerify: function(res) {
      this.recaptchaResponse = res;
      this.verified = true;
    },
    onExpire: function() {
      this.verified = false;
    }
  }
};
</script>

<style scoped>
</style>
