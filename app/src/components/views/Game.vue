<template>
    <div class="audio">
        <b-container v-if="!loaded">
            <h3 class="text-center w-100">Loading...</h3>
        </b-container>
        <music-runner
                v-if="loaded"
                :spectral="spectral"
                :beats="beats"
                :name="name"
                :audio="audio"
                @finished="onFinished"
        />
        <audio controls ref="audio" loop hidden>
            Your browser does not support the audio element.
        </audio>
    </div>
</template>

<script>
    import {apiJoin, uploadsJoin} from "../../utils/path";
    import MusicRunner from "../MusicRunner";
    import CryptoJS from 'crypto-js/hmac-sha256';

    export default {
        components: {MusicRunner},
        computed: {
            loaded: function() {
                return this.beats.length && this.spectral.length;
            }
        },
        data: function() {
            return {
                audios: [],
                items: [],
                spectral: [],
                beats: [],
                audio: null,
                name: 'Unknown',
                id: 0
            };
        },
        mounted() {
            this.$http.get(apiJoin("/audio/"+this.$route.params.id)).then((res) => {
                const audioData = res.data;

                this.name = audioData.title;
                this.$refs.audio.src = uploadsJoin('/audio/' + audioData.file);
                this.$refs.audio.controls = true;
                this.audio = this.$refs.audio;
                this.spectral = audioData.fft;
                this.beats = audioData.beats;
                this.id = audioData.id;
            })
        },
        methods: {
            onFinished: function(score) {
                if (this.$auth.check()) {
                    this.$http.post(apiJoin("/records/" + this.id + "/" + btoa((score - 999).toString())), {}, {
                        headers: {
                            Authorization: 'Bearer ' + this.$store.getters.jwt()
                        }
                    });
                }
            },
        }
    };
</script>
