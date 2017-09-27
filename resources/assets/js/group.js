
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


var i = 0;
const group = new Vue({
    el: '#group',
    data: {
        search: '',
        groups: [],
        successMsg: '',
        bottom: false,
    },
    watch: {
        bottom(bottom) {
            if (bottom) {
                this.Post();
            }
        }
    },
    ready: function () {

    },
    computed: {
        filteredGroups: function () {
            this.Group();
            return this.groups.filter((group) => {
                return group.name.toLowerCase().match(this.search.toLowerCase());
        });
        }
    },
    created() {
        window.addEventListener('scroll', () => {
            this.bottom = this.bottomVisible()
    });
        this.Group();
    },
    methods:{
        bottomVisible() {
            const scrollY = window.scrollY
            const visible = document.documentElement.clientHeight
            const pageHeight = document.documentElement.scrollHeight
            const bottomOfPage = visible + scrollY >= pageHeight
            return bottomOfPage || pageHeight < visible
        },
        Group() {
            axios.get('http://localhost:8000/groups')
                .then(response => {
                let ap = response.data[i++];
            let appInfo = {
                id: ap.id,
                user: ap.user,
                admins: ap.admins,
                slug: ap.slug,
                name: ap.name,
                created_at: ap.created_at,
                updated_at: ap.updated_at,
                description: ap.description,
                pic: ap.pic,
            };

            this.groups.push(appInfo)
            if (this.bottomVisible()) {
                this.Group();
            }

        })

        },
        joinToGroup(id) {
            axios.get('http://localhost:8000/dolaczDoGrupy/' + id)
                .then(response => {
                console.log(response);
                this.name = // show if success
            console.log('Zostałes nowym czlonkiem grupy');
            if (response.status === 200) {
                group.groups = response.data;
            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
        leaveGroup(id,groupid) {
            axios.get('http://localhost:8000/odejdzZGrupy/' + id +'/'+ groupid)
                .then(response => {
                console.log(response);
            this.name = // show if success
                console.log('Zostałes usunięty z grupy grupy');
            if (response.status === 200) {
                group.groups = response.data;
            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },

    }

});
