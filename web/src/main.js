import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import BootstrapVue from "bootstrap-vue";
import "./registerServiceWorker";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "./assets/sass/common.sass";
import { pathJoin } from "./utils/path";
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueAuth from '@websanova/vue-auth'
import webSanovaAuth from './security/auth';
import webSanovaHttp from './security/http';
import webSanovaRouter from '@websanova/vue-auth/drivers/router/vue-router.2.x.js';

Vue.router = router;
Vue.http = axios;

Vue.use(VueAxios, axios);
Vue.use(VueAuth, {
    auth: webSanovaAuth,
    http: webSanovaHttp,
    router: webSanovaRouter,
    tokenStore: ['localStorage', 'cookie'],
    tokenDefaultName: 'T_D_AU',
    rolesVar: 'roles',
    loginData: {url: pathJoin('/api/login_check'), method: 'POST', redirect: '/', fetchUser: false },
    registerData: {url: pathJoin('/api/user/'), method: 'POST', redirect: '/login'},
    logoutData: {url: pathJoin('/api/logout'), method: 'POST', redirect: '/', makeRequest: false},
    fetchData: {url: pathJoin('/api/user/current'), method: 'GET', enabled: true},
    refreshData: {url: pathJoin('/api/token/refresh'), method: 'POST', enabled: true, interval: 5},
    token: [{
        request: 'Authorization',
        response: 'Authorization',
        authType: 'bearer',
        foundIn: 'response'
    }, {
        request: 'token',
        response: 'token',
        authType: 'bearer',
        foundIn: 'response'
    }]
});
Vue.use(BootstrapVue);

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");
