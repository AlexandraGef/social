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
const app = new Vue({
    el: '#app',
    data: {
        posts: [],
        friends:[],
        content: '',
        editContent: '',
        postId: '',
        a: '',
        successMsg: '',
        commentData: '',
        bottom: false,
        answerData:'',
        api:'',

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
        this.Post();
        this.friend();
    },

    methods: {
        bottomVisible() {
            const scrollY = window.scrollY
            const visible = document.documentElement.clientHeight
            const pageHeight = document.documentElement.scrollHeight
            const bottomOfPage = visible + scrollY >= pageHeight
            return bottomOfPage || pageHeight < visible
        },
        Post() {
            axios.get('http://localhost:8000/posty')
                .then(response => {
                        let api = response.data[i++];
                        let apiInfo = {
                            id: api.id,
                            user_id: api.user_id,
                            content: api.content,
                            status: api.status,
                            created_at: api.created_at,
                            updated_at: api.updated_at,
                            user: api.user,
                            likes: api.likes,
                            group_id: api.group_id,
                            comments: api.comments,
                        };
                    Vue.filter('myOwnTime', function (value) {
                        var moment = require('moment-timezone');
                        moment.locale('pl');
                        return moment.utc(value).utcOffset("-240").fromNow();
                    });

                    this.posts.push(apiInfo)
                    if (this.bottomVisible()) {
                        this.Post();
                    }

                })

        },
        friend() {
            axios.get('http://localhost:8000/checkFriends')
                .then(response => {
                console.log(response);
            app.friends = response.data;
        })
        .catch(function (error) {
                console.log(error);
            });
        },
        deletePost(id) {
            axios.get('http://localhost:8000/deletePost/' + id)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Post został usuniety');
                    if (response.status === 200) {
                        app.posts = response.data;

                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        addPost() {
            axios.post('http://localhost:8000/dodajPost', {
                content: this.content
            })
                .then(function (response) {
                    console.log('Post został udostępniony');
                    if (response.status === 200) {
                        app.posts = response.data;
                        app.content = '';

                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        editPost(id) {
            axios.post('http://localhost:8000/edytujPost',{
                editContent: this.editContent,
                id: id
            })
                .then(function (response) {
                    console.log('Post został zedytowany');
                    if (response.status === 200) {
                        app.posts = response.data;
                        app.editContent = '';
                        app.id = '';

                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        likePost(id) {
            axios.get('http://localhost:8000/lubie/' + id)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Post został polubiony');
                    if (response.status === 200) {
                        app.posts = response.data;
                        app.a = id;


                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        unlikePost(id) {
            axios.get('http://localhost:8000/nielubie/' + id)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Post został polubiony');
                    if (response.status === 200) {
                        app.posts = response.data;
                        app.a = 0;

                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        addComment(id) {
            axios.post('http://localhost:8000/dodajKomentarz', {
                comment: this.commentData,
                id: id
            })
                .then(function (response) {
                    console.log('saved successfully'); // show if success
                    if (response.status === 200) {
                        app.posts = response.data;
                        app.commentData = '';
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
                        app.posts = response.data;

                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        addAnswer(id) {
            axios.post('http://localhost:8000/dodajOdpowiedz', {
                comment: this.answerData,
                id: id
            })
                .then(function (response) {
                    console.log('saved successfully'); // show if success
                    if (response.status === 200) {
                        app.posts = response.data;
                        app.answerData = '';
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
            console.log('Odpowiedz została usunieta');
            if (response.status === 200) {
                app.posts = response.data;

            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },

    }
});
