
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


const search = new Vue({
    el: '#search',
    data: {
        search:'',
        allUsers:[],
        jobs:[],
    },
    ready:function(){
      this.created();
        this.created1();
      this.filteredUsers();
    },
    created(){
            axios.get('http://localhost:8000/uzytkownicy')
                .then(response => {
                    console.log(response);
                    search.allUsers = response.data;
                })
                .catch(function (error){
                    console.log(error);
                });
        },
    created1(){
        axios.get('http://localhost:8000/jobss')
            .then(response => {
            console.log(response);
        search.jobs = response.data;
    })
    .catch(function (error){
            console.log(error);
        });
    },
    computed:{
        filteredUsers: function(){
            return this.allUsers.filter((user) => {
                return user.name.match(this.search);
            });
        }
    }

});
