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
// register globally
var i = 0;
const notifi = new Vue({
    el: '#notifi',
    data: {
        services: [],
        api:'',
        msgPost:'',
        msgCom:'',
        msgAns:'',
        msg:'',
        seen:false,
        seenPost:false,
        seenCom:false,
        seenAns:false,
    },
    watch: {
        bottom(bottom) {
            if (bottom) {
                this.Post();
            }
        }
    },
    created() {
        window.addEventListener('scroll', () => {
            this.bottom = this.bottomVisible()
        })
        this.not();
    },

    methods: {
        bottomVisible() {
            const scrollY = window.scrollY
            const visible = document.documentElement.clientHeight
            const pageHeight = document.documentElement.scrollHeight
            const bottomOfPage = visible + scrollY >= pageHeight
            return bottomOfPage || pageHeight < visible
        },
        not() {
            axios.get('http://localhost:8000/noti')
                .then(response => {
                        let api = response.data[i++];
                        let apiInfo = {
                            id: api.id,
                            excuse: api.excuse,
                            created_at: api.created_at,
                            updated_at: api.updated_at,
                            user: api.user,
                            profile: api.profile,
                            post: api.post,
                            comment: api.comment,
                            answer: api.answer,
                            group: api.group
                        };
                    Vue.filter('myOwnTime', function (value) {
                        var moment = require('moment-timezone');
                        moment.locale('pl');
                        return moment.utc(value).utcOffset("-240").fromNow();
                    });
                    this.services.push(apiInfo)
                    if (this.bottomVisible()) {
                        this.not();
                    }

                })

        },
        deletePost(id) {
            axios.get('http://localhost:8000/deletePost/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Post został usuniety');
            if (response.status === 200) {
                notifi.services = response.data;
                notifi.seenPost = true;
                notifi.msgPost = 'Post został usunięty';

            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
        deleteComment(id) {
            axios.get('http://localhost:8000/usunKomentarz/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Komentarz został usuniety');
            if (response.status === 200) {
                notifi.services = response.data;
                notifi.seenCom = true;
                notifi.msgCom = 'Komentarz został usunięty';

            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
        deleteAnswer(id) {
            axios.get('http://localhost:8000/usunOdpowiedz/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Odpowiedź została usunieta');
            if (response.status === 200) {

                notifi.services = response.data;
                notifi.seenAns = true;
                notifi.msgAns = 'Odpowiedź została usunięta';
            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
        deleteNoti(id) {
            axios.get('http://localhost:8000/usunZgloszenie/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Zgloszenie zostalo usuniete');
            if (response.status === 200) {

                notifi.services = response.data;
                notifi.seen = true;
                notifi.msg = 'Zgłoszenie zostało usunięte';
            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },


    }
});
