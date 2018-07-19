import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import About from "./views/About.vue";
import Login from "./views/auth/Login";
import page404 from "./views/Page404";
import SignUp from "./views/auth/SignUp";
import Resetting from "./views/auth/Resetting";
import ResettingConfirmed from "./views/auth/ResettingConfirmed";
import Settings from "./views/profile/Settings";

Vue.use(Router);

let router = new Router({
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
      path: "/settings",
      name: "settings",
      component: Settings,
      meta: {
        auth: true,
        title: "Mintme | Settings"
      }
    },
    {
      path: "/resetting",
      name: "resetting",
      component: Resetting,
      meta: { auth: false }
    },
    {
      path: "/resetting/confirm/:confirmationToken",
      name: "resseting_confirm",
      component: ResettingConfirmed,
      meta: { auth: false }
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
    },
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: {
        title: "Mintme | Login",
        auth: false
      },
      children: [
        {
          path: "confirm/:confirmationToken",
          component: Login
        }
      ]
    }
  ],
  mode: "history"
});

router.beforeEach((to, from, next) => {
  if (undefined !== to.meta.title) {
    document.title = to.meta.title;
  } else {
    document.title = "Mintme";
  }
  next();
});

export default router;
