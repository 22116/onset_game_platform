import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import BootstrapVue from "bootstrap-vue";
import "./registerServiceWorker";
import "bootstrap-vue/dist/bootstrap-vue.css"
const dotEnv = require("dotenv");

let res = dotEnv.config();

console.log(res);

console.log(process.env);

Vue.use(BootstrapVue);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
