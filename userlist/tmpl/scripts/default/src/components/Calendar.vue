<template>
  <div>

    <table v-if="acl.read == 1" class="si-table">
      <thead>
      <tr>
        <td>Datum</td>
        <td>Uhrzeit</td>
        <td>Dauer</td>
        <td>Zugriff</td>
        <td>Benutzer</td>
        <td>Info</td>
      </tr>
      </thead>
      <tbody class="">
      <tr v-bind:key="j" v-for="(date, j) in dates" >
        <td :class="{'text-orange': date.today == true, 'text-grey': date.done == true}">{{day(date.date)}} - {{date.slot.day}}</td>
        <td class="">{{date.slot.time}}</td>
        <td class="">{{date.slot.duration}} Min</td>
        <td class="">

          <button v-if="date.slot.typ.schueler"
              class="si-btn si-btn-off margin-r-m">Schüler</button>
          <button v-if="date.slot.typ.eltern"
                  class="si-btn si-btn-off margin-r-m">Eltern</button>

        </td>
        <td class=""><User v-bind:data="date.user"></User></td>
        <td class="">{{date.info}}</td>
      </tr>
      </tbody>
    </table>

  </div>
</template>


<script>

import User from '../mixins/User.vue'

export default {
  components: {
    User
  },
  name: 'Calendar',
  props: {
    dates: Array,
    acl: Object
  },
  data() {
    return {

    }
  },
  created: function () {

  },
  computed: {

  },
  methods: {

    day: function (day) {
      return this.$date(day).format('D.MM.YYYY');
    }

  }
}
</script>
