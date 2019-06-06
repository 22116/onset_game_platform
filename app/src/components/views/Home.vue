<template>
  <div class="home">
    <b-container>
      <h3 class="text-center w-100">Put your audio here to start new game or search for a generated one</h3>
      <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" @vdropzone-success="audioUploaded"></vue-dropzone>
    </b-container>
  </div>
</template>
<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import {apiJoin} from "../../utils/path";

export default {
  name: "home",
  components: {
    vueDropzone: vue2Dropzone
  },
  data: function() {
    return {
      dropzoneOptions: {
        url: apiJoin("/audio"),
        withCredentials: true,
        thumbnailWidth: 150,
        maxFilesize: 15,
        headers:  {
          Accept: 'application/json, text/plain, */*'
        },
        acceptedFiles: "audio/*",
        timeout: 500000
      }
    };
  },
  methods: {
    audioUploaded: function (file, response) {
      this.$router.push({ name: 'game', params: { id: response.id } })
    }
  },
};
</script>

