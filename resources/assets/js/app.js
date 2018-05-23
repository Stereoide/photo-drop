
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

if (false) {
Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
}

/* jQuery stuff */

jQuery(function() {
    /* Dropzone */

    var $dropzoneForm = jQuery('FORM.dropzone');
    console.log($dropzoneForm);
    if ($dropzoneForm.length > 0) {
        $dropzoneForm.dropzone({
            paramName: 'photo',
            chunking: true,
            forceChunking: true,
            chunkSize: 1024 * 512,
            parallelUploads: 2,
            maxFilesize: 128,
            timeout: 10000,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.mov,.mp4,.mpg",
            init: function () {
                this.on('error', function (file, errorMessage, xmlHttpRequest) {
                    console.error(errorMessage, xmlHttpRequest);
                });
            }
        });
    }
});
