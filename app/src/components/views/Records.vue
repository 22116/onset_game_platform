<template>
  <div class="records">
    <b-container>
      <b-card>
        <b-card-header>
          <h1>Records</h1>
        </b-card-header>
        <b-card-body>
          <b-table striped hover :items="items" @row-clicked="rowClicked"></b-table>
          <p>{{ jwtUsername }}</p>
        </b-card-body>
      </b-card>
    </b-container>
    <audio controls ref="audio" loop hidden>
      Your browser does not support the audio element.
    </audio>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import {apiJoin} from "../../utils/path";

export default {
  computed: {
    ...mapGetters(["jwtUsername"]),
  },
  data: function() {
    return {
      items: [],
    };
  },
  methods: {
    rowClicked: function (row) {
      this.$router.push({ name: 'game', params: { id: row.id } });
    }
  },
  mounted() {
    this.$http.get(apiJoin("/audio")).then((res) => {
      this.items = res.data.map((el) => {
        return {
          id: el.id,
          title: el.title,
          duration: el.duration + ' seconds',
          createdDate: el.createdDate,
          record: el.record ? el.record.value : '-',
          recordOwner: el.record ?
                  (el.record.profile ? (el.record.profile.firstName + ' ' + el.record.profile.lastName) : '-') :
                  '-'
        };
      });
    })
  }
};
</script>

<style lang="sass">
  .records
    .card-body
      padding: 0 !important

    tr
      cursor: pointer

      td:nth-of-type(2)
        color: #3498db
        text-decoration: underline
</style>
