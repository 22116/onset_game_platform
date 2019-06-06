<template>
    <div class="game">
        <b-row justify-content-center>
            <b-col>
                <h3>
                    {{name}}
                </h3>
            </b-col>
        </b-row>
        <b-row class="mt-5">
            <b-col>
                <strong>
                    Fails: {{ fails }}
                </strong>
            </b-col>
            <b-col>
                <strong>
                    Record: {{ record }}
                </strong>
            </b-col>
        </b-row>
        <b-row class="mt-3">
            <b-col>
                <game
                        :audio="audio"
                        :data="spectral"
                        :beats="beats"
                        :interval="interval"
                        :min="4.5"
                        :multiplier="12"
                        @coilision-touched="colisionTouched"
                        @changed="onChanged"
                        @finished="onFinished"
                />
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <div id="chart">
                    <chart :data="spectral" :current="currentIndex"></chart>
                </div>
            </b-col>
        </b-row>
    </div>
</template>
<script>
    import Game from 'onset-runner/src/components/Game';
    import Chart from './Chart'

    export default {
        components: {
            Chart,
            Game
        },
        props: {
            spectral: { type: Array, required: true },
            beats: { type: Array, required: true },
            audio: HTMLAudioElement | null,
            name: { type: String, required: true },
        },
        data: function() {
            return {
                interval: 500,
                currentIndex: 0,
                fails: 0,
                record: 0,
            };
        },
        methods: {
            colisionTouched: function () {
                this.fails++;
                document.body.style.backgroundColor = '#F00';
                setTimeout(() => {
                    document.body.style.backgroundColor = '#FFF'
                }, 300);
            },
            onChanged: function(index) {
                this.currentIndex = index + 1;
            },
            onFinished: function (score) {
                this.fails = 0;

                this.$emit('finished', score);
            }
        },
    };
</script>

<style lang="sass">
    body
        transition: background-color 0.3s linear

        .game
            margin-top: 90px
            position: relative
            overflow-x: hidden

        #chart
            margin-top: -100px
</style>
