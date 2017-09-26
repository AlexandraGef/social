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
const friends = new Vue({
    el: '#friends',
    data: {
        search: '',
        myFriends: [],


    },
    watch: {
        bottom(bottom) {
            if (bottom) {
       this.Users();
            }
        }
    },
    created() {
        window.addEventListener('scroll', () => {
            this.bottom = this.bottomVisible()
    })
        this.Users();
    },
    computed: {
        filteredFriends: function () {
            this.Users();
            return this.myFriends.filter((friend) => {
                return friend.name.toLowerCase().match(this.search.toLowerCase());
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
        Users() {
            axios.get('http://localhost:8000/moiZnajomi')
                .then(response => {
                let api = response.data[i++];
            let apiInfo = {
                id: api.id,
                name: api.name,
                pic: api.pic,
                slug: api.slug,
            };
            this.myFriends.push(apiInfo)
            if (this.bottomVisible()) {
                this.Users();
            }

        })

        },
        deleteFromFriends(id) {
            axios.get('http://localhost:8000/usunZnajomego/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Znajomy został usuniety');
            if (response.status === 200) {
                friends.myFriends = response.data;


            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },

    }

});
