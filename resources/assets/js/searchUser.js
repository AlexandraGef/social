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


const searchUser = new Vue({
    el: '#searchUser',
    data: {
        search: '',
        allUsers: [],
        checks:[],
        a: '',
        b:'',
    },
    created() {
        axios.get('http://localhost:8000/uzytkownicy')
            .then(response => {
                console.log(response);
                searchUser.allUsers = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        axios.get('http://localhost:8000/czyWyslaneZapro')
            .then(response => {
                console.log(response);
                searchUser.checks = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    computed: {
        filteredUsers: function () {
            return this.allUsers.filter((user) => {
                return user.name.toLowerCase().match(this.search.toLowerCase());
            });
        }
    }

});
