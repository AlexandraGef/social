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


const searchJobs = new Vue({
    el: '#searchJobs',
    data: {
        search: '',
        jobs: [],
    },
    created() {
        axios.get('http://localhost:8000/jobs')
            .then(response => {
                console.log(response);
                searchJobs.jobs = response.data;
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    computed: {
        filteredJobs: function () {
            return this.jobs.filter((job) => {
                return job.job_title.toLowerCase().match(this.search.toLowerCase());
            });
        }
    }

});