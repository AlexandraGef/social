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
    el: '#search',
    data: {
        queryString: '',
    },

    methods: {
        getResult(){
            axios.get('http://localhost:8000/search',{params:{queryString: search.queryString}}).then(response => {
                console.log(response.data);
        });
        }
    }

});
