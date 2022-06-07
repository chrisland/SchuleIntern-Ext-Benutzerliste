<template>
  <div>

    <Error v-bind:error="error"></Error>
    <Spinner v-bind:loading="loading"></Spinner>

    <List v-bind:items="items" ></List>

  </div>
</template>

<script>

const axios = require('axios').default;

import Error from './mixins/Error.vue'
import Spinner from './mixins/Spinner.vue'

import ModalForm from './mixins/ModalForm.vue'

import Form from './components/Form.vue'
import List from './components/List.vue'


export default {
  components: {
    Error, Spinner, Form, List, ModalForm
  },
  data() {
    return {
      apiURL: globals.apiURL,
      acl: globals.acl,

      loading: false,
      error: false,

      form: {},
      items: globals.items || []
    };
  },
  created: function () {

    //this.loadLists();



  },
  mounted() {

    var that = this;


    EventBus.$on('member--submit', data => {

      if (!data.item_id) {
        console.log('missing');
        return false;
      }

      const formData = new FormData();
      formData.append('id', data.item_id);
      if (data.toggle !== undefined) {
        formData.append('toggle', data.toggle);
      }
      if (data.info) {
        formData.append('info', data.info);
      }


      this.loading = true;
      var that = this;
      axios.post( this.apiURL+'/setMember', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(function(response){
        if ( response.data ) {
          if (response.data.error == false) {

            //EventBus.$emit('calender--reload', {});
            if (data.callback) {
              data.callback();
            }
          } else {
            that.error = ''+response.data.msg;
          }
        } else {
          that.error = 'Fehler beim Laden. 01';
        }
      })
      .catch(function(){
        that.error = 'Fehler beim Laden. 02';
      })
      .finally(function () {
        // always executed
        that.loading = false;
      });



    });



/*
    EventBus.$on('form--submit', data => {

      if (!data.item.title
          || !data.members || data.members.length < 1) {
        console.log('missing');
        return false;
      }

      const formData = new FormData();
      formData.append('title', data.item.title);
      formData.append('members', data.members);
      formData.append('owners', data.owners);

      this.loading = true;
      var that = this;
      axios.post( this.apiURL+'/setList', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(function(response){
        if ( response.data ) {
          if (response.data.insert) {

            that.loadLists();
            EventBus.$emit('modal-form--close', {});

          } else {
            that.error = ''+response.data.msg;
          }
        } else {
          that.error = 'Fehler beim Laden. 01';
        }
      })
      .catch(function(){
        that.error = 'Fehler beim Laden. 02';
      })
      .finally(function () {
        // always executed
        that.loading = false;
      });



    });
  */
  },
  methods: {

    /*
    handlerOpenForm: function () {
      EventBus.$emit('modal-form--open');
    },

    loadLists: function () {
      this.loading = true;
      var that = this;
      axios.get( this.apiURL+'/getList')
      .then(function(response){
        if ( response.data ) {
          if (!response.data.error) {

            that.items = response.data;

          } else {
            that.error = ''+response.data.msg;
          }
        } else {
          that.error = 'Fehler beim Laden. 01';
        }
      })
      .catch(function(){
        that.error = 'Fehler beim Laden. 02';
      })
      .finally(function () {
        // always executed
        that.loading = false;
      });
    }
 */
  }

};
</script>

<style>

</style>