/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
window.Echo.channel('admin-bookings') 
    .listen('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
        console.log("Notification Received:", e);

        let notiCount = $('.badge-counter .count');
        let current = parseInt(notiCount.text()) || 0;
        notiCount.text(current + 1);

        let html = `
            <a class="dropdown-item d-flex align-items-center" href="${e.actionURL}">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas ${e.fas} text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">${e.created_at}</div>
                    <span class="font-weight-bold">${e.title}</span>
                </div>
            </a>`;
        $('.dropdown-list').prepend(html);
    });

    
    import Echo from 'laravel-echo';
    import Pusher from 'pusher-js';
    
    window.Pusher = Pusher;
    
    window.Echo = new Echo({
      broadcaster: 'pusher',
      key: '126345336d8adfa7da65',
      cluster: 'ap1',
      forceTLS: true
    });
    
    var channel = window.Echo.channel('my-channel');
    channel.listen('.my-event', function(data) {
      alert(JSON.stringify(data));
    });
    