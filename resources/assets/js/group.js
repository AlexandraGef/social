
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const group = new Vue({
    el: '#group',
    data: {
        search: '',
        groups: [],
    },
    ready: function () {
        this.created();
        this.filteredGroups();
    },
    created() {
        axios.get('http://localhost:8000/groups')
            .then(response => {
            console.log(response);
        group.groups = response.data;
    })
    .catch(function (error) {
            console.log(error);
        });
    },
    computed: {
        filteredGroups: function () {
            return this.groups.filter((group) => {
                return group.name.toLowerCase().match(this.search.toLowerCase());
        });
        }
    }

});
