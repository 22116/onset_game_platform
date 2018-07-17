<template>
  <form @submit.prevent="onSubmit" ref="form">
    <div v-if="showInvalid" class="alert alert-danger">Whoops! Seems you've entered invalid data.</div>
    <slot></slot>
  </form>
</template>

<script>
  import connector from "../utils/connector";
  import serialize from "form-serialize";
  import _ from "lodash";

  export default {
    name: "VueForm",
    props: {
      action: String,
      method: String,
      dataPrefix: String,
      isSecure: Boolean,
      doNothing: Boolean
    },
    data() {
      return {
        showInvalid: false
      };
    },
    methods: {
      onSubmit: function () {
        let that = this;
        let data = serialize(this.$refs.form, { hash: true });

        this.$emit("beforeSubmit", data);

        if (!this.doNothing) {
          connector(this.action, this.method, data, this.isSecure)
            .then(function () {
              that.$emit("onSuccess");
            })
            .catch(function (error) {
              that.$emit("onFail");
              let res = error.response;
              if (res.status === 400) {
                if (res.data.hasOwnProperty('errors')) {
                  that.showErrors(res.data.errors);
                  that.showInvalid = false;
                }
                else {
                  that.showInvalid = true;
                }
              }
            });
        }

        this.$emit("onSubmit");
      },
      showErrors: function (errors) {
        this.clearErros();

        let that = this;
        let prefix = this.dataPrefix === undefined ? '' : this.dataPrefix;
        let fetchedData = this.fetchErrors(errors, prefix);
        
        _.forEach(fetchedData, function (value) {
          let el = that.$refs.form.querySelector("[name='" + value[0] + "']");
          let error = document.createElement('div');
          error.classList.add('alert');
          error.classList.add('alert-danger');
          error.innerHTML = value[1];
          el.parentNode.insertBefore(error, el);
        });
      },
      clearErros: function () {
        let errors = this.$refs.form.getElementsByClassName("alert-danger");
        _.forEach(errors, function (error) {
          error.remove();
        })
      },
      fetchErrors: function (errors, prefix = "") {
        let that = this;
        let result = [];

        if (errors.hasOwnProperty("children")) {
          return that.fetchErrors(errors.children, prefix);
        } else {
          _.forOwn(errors, function (value, index) {
            if ("" !== prefix)
              index = "[" + index + "]";

            if (value.hasOwnProperty("children")) {
              result.push(_.flatten(that.fetchErrors(value, prefix + index)));
            } else if (value.hasOwnProperty("errors")) {
              result.push([prefix + index, value.errors[0]]);
            }
          });
        }

        return result;
      }
    }
  }
</script>

<style scoped>

</style>