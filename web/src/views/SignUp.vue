<template>
    <div class="container">
        <div class="row justify-content-center">
            <VueForm v-if="!showConfirm" action="/auth/register" method="POST" @onSuccess="submit">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input name="email" type="email" v-model="email" class="form-control" id="email" />
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input name="plainPassword[first]" type="password" class="form-control" id="pwd" />
                </div>
                <div class="form-group">
                    <label for="rpwd">Repeat Password:</label>
                    <input name="plainPassword[second]" type="password" class="form-control" id="rpwd" />
                </div>
                <input name="g-recaptcha-response" type="hidden" :value="recaptchaResponse" />
                <vue-recaptcha :sitekey="sitekey" size="normal" type="checkbox" @verify="onVerify" @expired="onExpire">
                    <button type="submit" class="btn btn-primary mt-2 float-right" :disabled="!verified">Submit</button>
                </vue-recaptcha>
            </VueForm>
            <div v-if="showConfirm">
                <p>An email has been sent to {{ email }}. It contains an activation link you must click to activate your account.</p>
                <p>Do not forget to check your spam folder</p>
            </div>
        </div>
    </div>
</template>

<script>
import VueForm from "../components/VueForm";
import VueRecaptcha from "vue-recaptcha";

export default {
  name: "SignUp",
  components: {
    VueRecaptcha,
    VueForm
  },
  data() {
    return {
      verified: false,
      sitekey: process.env.RECAPTCHA_SITEKEY,
      showConfirm: false,
      email: null,
      rememberMe: false,
      recaptchaResponse: null
    };
  },
  methods: {
    submit: function(req) {
      if (req.status === 200) this.showConfirm = true;
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
