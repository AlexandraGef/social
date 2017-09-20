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

const crud = new Vue({
    el: '#crud',
    data: {
        search: '',
        tables: [],
        msg:'',
        seen: false,
    },
    ready: function () {
        this.created();
    },
    created() {
        axios.get('http://localhost:8000/admin/tabele')
            .then(response => {
                console.log(response);
                crud.tables = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
    },

    methods: {
        deleteTable(name) {
            axios.get('http://localhost:8000/admin/deleteTable/' + name)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Tabela została usunięta');
                    axios.get('http://localhost:8000/admin/tabele')
                        .then(response => {
                            crud.tables = response.data;
                            crud.seen = true;
                            crud.msg = 'Tabela została pomyslnie usunięta'
                        })
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },

    }


});
