<template>
  <form @submit.prevent="onSubmit" ref="form">
    <slot></slot>
  </form>
</template>

<script>
  import connector from "../utils/connector";
  import serialize from "form-serialize";

  export default {
    name: "VueForm",
    props: {
      action: String,
      method: String,
      isSecure: Boolean
    },
    methods: {
      onSubmit: function () {
        let that = this;
        let data = serialize(this.$refs.form, { hash: true });
        this.$emit("beforeSubmit", data);
        connector(this.action, this.method, data, this.isSecure)
          .then(function () {
            that.$emit("onSuccess");
          })
          .catch(function () {
            that.$emit("onFail");
          });
        this.$emit("onSubmit");
      }
    }
  }
</script>

<style scoped>

</style>