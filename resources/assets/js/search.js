/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');




/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// register globally

const search = new Vue({
    el: '#search-nav',
    data: {
        queryString: '',
        us:[],
    },

    methods: {
        getResult() {
            axios.post('http://localhost:8000/api/search', {
                queryString: search.queryString,
            })
                .then(function (response) {
                    console.log('uzytkownicy'); // show if success
                    if (response.status === 200) {
                        search.us = response.data;
                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });

        },
    }

});
