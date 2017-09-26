
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
        posts: [],
        content: '',
        editContent: '',
        postId:'',
        a: '',
        successMsg: '',
        commentData: '',
        bottom: false,
        answerData:'',
        api:'',
        g:0,
        admin:0,

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
            return this.groups.filter((group) => {
                return group.name.toLowerCase().match(this.search.toLowerCase());
        });
        }
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
        window.addEventListener('scroll', () => {
            this.bottom = this.bottomVisible()
    })
        this.Post();
    },
    methods:{
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
                group_id: api.group_id,
                content: api.content,
                status: api.status,
                created_at: api.created_at,
                updated_at: api.updated_at,
                user: api.user,
                likes: api.likes,
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

        deletePost(id) {
            axios.get('http://localhost:8000/deletePost/' + id)
                .then(response => {
                console.log(response); // show if success
            console.log('Post został usuniety');
            if (response.status === 200) {
                group.posts = response.data;

            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
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
                        group.posts = response.data;
                        group.editContent = '';
                        group.id = '';

                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        addPostGroup(id) {
            axios.post('http://localhost:8000/dodajPostGrupy',{
                content: this.content,
                id: id
            })
                .then(function (response) {
                    console.log('Post został zedytowany');
                        if (response.status === 200) {
                            group.posts = response.data;
                            group.content = '';

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
                group.posts = response.data;
                group.a = id;


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
                group.posts = response.data;
                group.a = 0;

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
                        group.posts = response.data;
                        group.commentData = '';
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
                group.posts = response.data;

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
                        group.posts = response.data;
                        group.answerData = '';
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
                group.posts = response.data;

            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
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
        joinToGroup2(id) {
            axios.get('http://localhost:8000/dolaczDoGrupy/' + id)
                .then(response => {
                console.log(response);
            this.name = // show if success
                console.log('Zostałes nowym czlonkiem grupy');
            if (response.status === 200) {
                location.reload();
            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },
        leaveGroup2(id,groupid) {
            axios.get('http://localhost:8000/odejdzZGrupy/' + id +'/'+ groupid)
                .then(response => {
                console.log(response);
            this.name = // show if success
                console.log('Zostałes usunięty z grupy grupy');
            if (response.status === 200) {
                location.reload();

            }
        })
        .catch(function (error) {
                console.log(error); // run if we have error
            });
        },


    }

});
