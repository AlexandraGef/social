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



const profile = new Vue({
    el: '#profile',
    data: {
        content: '',
        msg: 'Aby rozpocząć nową konwersację, kliknij na użytkownika po lewej stronie',
        content: '',
        privateMsgs: [],
        singleMsgs: [],
        msgForm: '',
        conID: '',
        friend_id: '',
        seen: false,
        newMsgFrom: ''
    },
    ready: function () {
        this.created();
    },
    created() {
        axios.get('http://localhost:8000/getMessages')
            .then(response => {
                console.log(response.data);
                profile.privateMsgs = response.data;


            })
            .catch(function (error) {
                console.log(error);
            });
    },
    methods: {
        messages: function (id) {
            axios.get('http://localhost:8000/getMessages/' + id)
                .then(response => {
                    console.log(response.data);
                    profile.singleMsgs = response.data;
                    profile.conID = response.data[0].conversation_id;


                })
                .catch(function (error) {
                    console.log(error);
                });
        },

        inputHandler(e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                this.sendMsg();
            }

        },

        sendMsg() {
            if (this.msgForm) {
                axios.post('http://localhost:8000/wyslijWiadomosc', {
                    conID: this.conID,
                    msg: this.msgForm
                })
                    .then(function (response) {
                        console.log(response.data);
                        if (response.status === 200) {
                            profile.singleMsgs = response.data;

                        }

                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }

        },
        friendID: function (id) {
            profile.friend_id = id;
        },
        sendNewMsg() {
            axios.post('http://localhost:8000/wyslijNowaWiadomosc', {
                friend_id: this.friend_id,
                msg: this.newMsgFrom,
            })
                .then(function (response) {
                    console.log(response.data); // show if success
                    if (response.status === 200) {
                        window.location.replace('http://localhost:8000/wiadomosci');
                        profile.msg = 'Twoja wiadomość została wysłana';
                    }

                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        }


    }
});
