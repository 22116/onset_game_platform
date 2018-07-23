<template>
    <b-container>
        <b-row class="justify-content-center">
            <VueForm v-if="!showConfirm" action="/auth/register" method="POST" @onSuccess="submit">
                <b-form-group label="Email address:" label-for="email">
                    <b-form-input id="email" v-model="email" type="email" name="email" placeholder="Enter your email" />
                </b-form-group>
                <b-form-group label="Password:" label-for="pwd">
                    <b-form-input id="pwd" type="password" name="plainPassword[first]" placeholder="*********" />
                </b-form-group>
                <b-form-group label="Repeat Password:" label-for="rpwd">
                    <b-form-input id="rpwd" type="password" name="plainPassword[second]" placeholder="*********" />
                </b-form-group>
                <input name="g-recaptcha-response" type="hidden" :value="recaptchaResponse" />
                <vue-recaptcha :sitekey="sitekey" size="normal" type="checkbox" @verify="onVerify" @expired="onExpire">
                    <button class="btn btn-primary mt-2 float-right" type="submit" :disabled="!verified">Submit</button>
                </vue-recaptcha>
            </VueForm>
            <b-alert variant="success" :show="showConfirm">
                <p>An email has been sent to {{ email }}. It contains an activation link you must click to activate your account.</p>
                <p>Do not forget to check your spam folder</p>
            </b-alert>
        </b-row>
    </b-container>
</template>

<script>
import VueForm from "../../components/VueForm";
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
