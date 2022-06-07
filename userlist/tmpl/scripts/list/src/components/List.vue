<template>

  <div class="">

    <h2 class="padding-b-l">{{items.title}}</h2>

    <textarea>Listen info???</textarea>

    <br><br>
    Export Liste
    <br><br>
    Drucken
    <br><br><br>


    <div class="flex-row padding-b-l">
      <div class="flex-2">
        <button class="si-btn si-btn-off text-bold">{{items.stats.count}} Benutzer</button>
        <br>
        <span class="si-btn-multiple">
        <button class="si-btn si-btn-off">{{items.stats.isPupil}} Schüler </button>
        <button class="si-btn si-btn-off">{{items.stats.isEltern}} Eltern</button>
        <button class="si-btn si-btn-off">{{items.stats.isTeacher}} Lehrer</button>
        <button class="si-btn si-btn-off">{{items.stats.isNone}} Sonstige</button>
      </span>
      </div>
      <div class="flex-1">
        <label>Teilen mit:</label>
        <div v-bind:key="index" v-for="(item, index) in  items.owners" class="margin-b-s">
          <User v-if="item" v-bind:data="item"></User>
        </div>
      </div>
    </div>






    <table v-if="items.members" class="si-table si-table-style-firstLeft">
      <thead>
        <tr>
          <th width="30%" v-on:click="handlerSort('vorname')" class="curser">Vorname</th>
          <th v-on:click="handlerSort('nachname')" class="curser">Nachname</th>
          <th v-on:click="handlerSort('type')" class="curser">typ</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-bind:key="index" v-for="(item, index) in  sortedArray">
          <td class="">{{item.vorname}}</td>
          <td class="">{{item.nachname}}</td>
          <td class="">{{item.type}}</td>
          <td class="">
            <button v-if="item.toggle == 1" class="si-btn si-btn-toggle-on" v-on:click="handlerToggleMember(item)"><i class="fa fas fa-toggle-on"></i> An</button>
            <button v-else class="si-btn si-btn-toggle-off" v-on:click="handlerToggleMember(item)"><i class="fa fas fa-toggle-off"></i> Aus</button>
          </td>
          <td class=""><input type="text" maxlength="255" v-model="item.info" v-on:change="handlerInfoMember(item)"/> </td>
        </tr>
      </tbody>
    </table>


  </div>

</template>


<script>

import User from './../mixins/User.vue'

export default {
  components: {
    User
  },
  name: 'List',
  props: {
    items: Object
  },
  data(){
    return {
      sort: {
        column: false,
        order: true
      }
    }
  },
  computed: {
    sortedArray: function() {

      if (this.sort.column) {
        if (this.sort.order) {
          return this.items.members.sort((a, b) => a[this.sort.column].localeCompare(b[this.sort.column]))
        } else {
          return this.items.members.sort((a, b) => b[this.sort.column].localeCompare(a[this.sort.column]))
        }
      }
      return this.items.members;
    }
  },
  created: function () {
  },
  mounted() {
  },
  methods: {
    handlerToggleMember: function (item) {
      if (item.id) {

        let toggle = false;
        if (item.toggle == false || item.toggle == 0 || !item.toggle ) {
          toggle = true;
        }
        EventBus.$emit('member--submit', {
          item_id: item.id,
          toggle: toggle,
          callback: function () {
            item.toggle = toggle;
          }
        });


      }
    },
    handlerInfoMember: function (item) {
      EventBus.$emit('member--submit', {
        item_id: item.id,
        info: item.info
      });
    },
    handlerSort: function (column) {
      if (column) {
        this.sort.column = column;
        if (this.sort.order) {
          this.sort.order = false;
        } else {
          this.sort.order = true;
        }
      }
    }
  }
}
</script>
