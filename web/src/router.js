import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import About from "./views/About.vue";
import Login from "./views/Login";
import page404 from "./views/Page404";
import SignUp from "./views/SignUp";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/about",
      name: "about",
      component: About,
      meta: { auth: true }
    },
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: { auth: false },
      children: [
        {
          path: 'confirm/:confirmationToken',
          component: Login
        }
      ]
    },
    {
      path: "/register",
      name: "register",
      component: SignUp,
      meta: { auth: false }
    },
    {
      path: "*",
      name: "404",
      component: page404
    }
  ],
  mode: "history"
});
