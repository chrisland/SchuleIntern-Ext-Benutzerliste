<template>

  <div class="si-form">

    <ul class="">
      <li :class="required">
        <label>Titel</label>
        <input v-model="item.title" />
      </li>
      <li :class="required">
        <label>Benutzer</label>

        <UserSelect @submit="handlerUserSelectMembers"></UserSelect>

        <span v-bind:key="index" v-for="(item, index) in  members" class="margin-b-s">
          <User v-bind:data="item"></User>
        </span>
      </li>
      <li>
        <label>Liste Teilen mit</label>

        <UserSelect @submit="handlerUserSelectOwners"></UserSelect>

        <span v-bind:key="index" v-for="(item, index) in  owners" class="margin-b-s">
          <User v-bind:data="item"></User>
        </span>
      </li>
      <li>
        <button @click="submitForm" class="si-btn"><i class="fa fa-save"></i> Buchen</button>
      </li>
    </ul>
  </div>

</template>


<script>
import User from "../mixins/User.vue";
import UserSelect from '../mixins/UserSelect.vue'

export default {
  components: {
    User, UserSelect
  },
  name: 'Form',
  props: {
    item: Object
  },
  data(){
    return {

      error: false,
      required: '',

      members: false,
      owners: false
    }
  },
  created: function () {
  },
  mounted() {
    // access our input using template refs, then focus
  },
  methods: {

    handlerUserSelectMembers: function (userlist) {
      this.members = userlist;
      //this.item.members = [...this.item.members, ...userlist];
    },
    handlerUserSelectOwners: function (userlist) {
      this.owners = userlist;
      //this.item.members = [...this.item.members, ...userlist];
    },

    submitForm: function () {
      var that = this;
      //this.form.date = this.$date(this.form.date).format('YYYY-MM-DD')

      if (!this.item.title) {
        console.log('missing');
        this.required = 'required';
        return false;
      }

      let members = [];
      if (that.members.length > 0) {
        that.members.forEach((o) => {
          members.push(o.id);
        });
      } else {
        this.required = 'required';
        return false;
      }
      let owners = [];
      if (that.owners.length > 0) {
        that.owners.forEach((o) => {
          owners.push(o.id);
        });
      }

      EventBus.$emit('form--submit', {
        item: that.item,
        members: JSON.stringify(members),
        owners: JSON.stringify(owners)
      });

    }

  }
}
</script>
