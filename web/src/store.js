import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";
import { pathJoin } from "@/utils/path";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    currentJWT: "",
    currentRefreshToken: ""
  },
  getters: {
    jwt: state => state.currentJWT,
    jwtData: (state, getters) =>
      state.currentJWT ? JSON.parse(atob(getters.jwt.split(".")[1])) : null,
    jwtUsername: (state, getters) =>
      getters.jwtData ? getters.jwtData.username : null,
    jwtRoles: (state, getters) =>
      getters.jwtData ? getters.jwtData.roles : null,
    refreshToken: state => state.currentRefreshToken
  },
  mutations: {
    setJWT(state, jwt) {
      state.currentJWT = jwt.token;
      state.currentRefreshToken = jwt.refresh_token;
    }
  },
  actions: {
    async fetchJWT({ commit }, { username, password }) {
      axios
        .post(
          pathJoin("/api/login_check"),
          {
            username: username,
            password: password
          },
          {
            headers: {
              "Content-Type": "application/json"
            }
          }
        )
        .then(response => commit("setJWT", response.data))
        .catch(error => console.log(error));
    },
  }
});
