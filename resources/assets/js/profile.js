
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const profile = new Vue({
    el: '#profile',
    data: {
  content:'',
        msg:'heheh',
        privateMsgs:[],
        singleMsgs:[]
    },
    ready:function(){
      this.created();
    },
    created(){
            axios.get('http://localhost:8000/getMessages')
                .then(response => {
                    console.log(response.data);
                profile.privateMsgs = response.data;


                })
                .catch(function (error){
                    console.log(error);
                });
        },
    methods: {
        messages: function(id){
            axios.get('http://localhost:8000/getMessages/'+ id)
                .then(response => {
                    console.log(response.data);
                    profile.singleMsgs = response.data;


                })
                .catch(function (error){
                    console.log(error);
                });
        }


    }
});
