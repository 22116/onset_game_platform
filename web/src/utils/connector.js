import store from "../store";
import axios from "axios";
import { apiJoin } from "./path";

export default function (route, method, data, isSecure = false) {
    let request =  axios.request({
      url: apiJoin(route),
      method: method,
      data: data
    });

    if (isSecure) {
      request.headers.add({
          Authorization: "Bearer " + store.getters.jwt
        });
    }

    return request;
}