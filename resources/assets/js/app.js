
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


const app = new Vue({
    el: '#app',
    data: {
        posts:[],
        content: '',
    },
    ready:function(){
      this.created();
    },
    created(){
            axios.get('http://localhost:8000/posty')
                .then(response => {
                    console.log(response);
                    app.posts = response.data;
                    Vue.filter('myOwnTime', function(value){
                        var moment = require('moment-timezone');
                        moment.locale('pl');

                        return moment.utc(value).utcOffset("-240").fromNow();
                    });


                })
                .catch(function (error){
                    console.log(error);
                });
        },
    methods: {
        deletePost(id){
            axios.get('http://localhost:8000/deletePost/' + id)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Post został usuniety');
                    if(response.status===200){
                        app.posts = response.data;

                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        addPost() {
            axios.post('http://localhost:8000/dodajPost',{
                content: this.content
            })
                .then(function (response){
                    console.log('Post został udostępniony');
                    if(response.status===200){
                       app.posts = response.data;

                    }
                })
                .catch(function (error){
                    console.log(error);
                });
        },
        likePost(id){
            axios.get('http://localhost:8000/lubie/' + id)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Post został usuniety');
                    if(response.status===200){
                        app.posts = response.data;

                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },
        unlikePost(id){
            axios.get('http://localhost:8000/nielubie/' + id)
                .then(response => {
                    console.log(response); // show if success
                    console.log('Post został usuniety');
                    if(response.status===200){
                        app.posts = response.data;

                    }
                })
                .catch(function (error) {
                    console.log(error); // run if we have error
                });
        },

    }
});
