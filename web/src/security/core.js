import auth from "./auth";
import http from "./http";
import router from "@websanova/vue-auth/drivers/router/vue-router.2.x.js";
import { apiJoin } from "../utils/path";

export default {
  auth: auth,
  http: http,
  router: router,
  tokenStore: ["localStorage", "cookie"],
  tokenDefaultName: "T_S_AU",
  rolesVar: "roles",
  loginData: {
    url: apiJoin("/login_check"),
    method: "POST",
    redirect: "/",
    fetchUser: false
  },
  registerData: {
    url: apiJoin("/auth/register"),
    method: "POST"
  },
  logoutData: {
    url: apiJoin("/auth/logout"),
    method: "POST",
    redirect: "/",
    makeRequest: true
  },
  fetchData: {
    url: apiJoin("/user/current"),
    method: "GET",
    enabled: true
  },
  refreshData: {
    url: apiJoin("/token/refresh"),
    method: "POST",
    enabled: true,
    interval: 5
  },
  token: [
    {
      request: "Authorization",
      response: "Authorization",
      authType: "bearer",
      foundIn: "response"
    }
  ]
};