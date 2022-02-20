<template>

  <div class="">

    <table class="si-table si-table-style-firstLeft">
      <thead>
        <tr>
          <th width="30%">Titel</th>
          <th>Mitglieder</th>
          <th></th>
          <th>Shared</th>
        </tr>
      </thead>
      <tbody>
        <tr v-bind:key="index" v-for="(item, index) in  items">
          <td class="padding-l-m">{{item.title}}</td>
          <td><button class="si-btn si-btn-off text-bold">{{item.members.length}}</button></td>
          <td class="si-btn-multiple">
            <button class="si-btn si-btn-off">{{item.stats.isPupil}} Schüler </button>
            <button class="si-btn si-btn-off">{{item.stats.isEltern}} Eltern</button>
            <button class="si-btn si-btn-off">{{item.stats.isTeacher}} Lehrer</button>
            <button class="si-btn si-btn-off">{{item.stats.isNone}} Sonstige</button>
          </td>
          <td>
            <span v-bind:key="index" v-for="(user, index) in  item.owners" class="margin-r-m">
              {{user.name}}
            </span>
          </td>
        </tr>
      </tbody>
    </table>

  </div>

</template>


<script>

export default {
  components: {
  },
  name: 'List',
  props: {
    items: Array
  },
  data(){
    return {

    }
  },
  created: function () {
  },
  mounted() {
  },
  methods: {

  }
}
</script>
