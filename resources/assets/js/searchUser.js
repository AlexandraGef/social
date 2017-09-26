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

var i = 0;
const searchUser = new Vue({
    el: '#searchUser',
    data: {
        search: '',
        allUsers: [],
        checks:[],
        a: '',
        b:'',
        api:'',
    },
    watch: {
        bottom(bottom) {
            if (bottom) {
                tihs.User();
            }
        }
    },
    created() {
        axios.get('http://localhost:8000/czyWyslaneZapro')
            .then(response => {
                console.log(response);
                searchUser.checks = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        window.addEventListener('scroll', () => {
            this.bottom = this.bottomVisible()
    })
        this.User();
    },
    computed: {
        filteredUsers: function () {
            this.User();
            return this.allUsers.filter((user) => {
                return user.name.toLowerCase().match(this.search.toLowerCase());

            })
        }
    },

    methods: {
        bottomVisible() {
            const scrollY = window.scrollY
            const visible = document.documentElement.clientHeight
            const pageHeight = document.documentElement.scrollHeight
            const bottomOfPage = visible + scrollY >= pageHeight
            return bottomOfPage || pageHeight < visible
        },
        User() {
            axios.get('http://localhost:8000/uzytkownicy')
                .then(response => {
                let api = response.data[i++];
            let apiInfo = {
                id: api.id,
                about: api.about,
                city: api.city,
                country: api.country,
                name: api.name,
                pic: api.pic,
                slug: api.slug,
                user_id: api.user_id
            };
            this.allUsers.push(apiInfo)
            if (this.bottomVisible()) {
                this.User();
            }

        })

        },
        deleteFromFriends(id) {
            axios.get('http://localhost:8000/usun/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Znajomy został usuniety');
            if (response.status === 200) {
                searchUser.a = '';
                searchUser.b='';
                searchUser.checks = response.data;



            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
        addFriends(id) {
            axios.get('http://localhost:8000/dodajZnajomego/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Znajomy został usuniety');
            if (response.status === 200) {
                searchUser.a = '';
                searchUser.b='';
                searchUser.checks = response.data;


            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
    }

});
