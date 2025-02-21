window._ = require('lodash');


import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: process.env.MIX_PUSHER_HOST || '127.0.0.1',
    wsPort: process.env.MIX_PUSHER_PORT || 6001,
    forceTLS: false, // false for local dev
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});


try {

    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}





window.Echo.join('status-update')
    .here((users) => {

        for(let x = 0 ; x < users.length ; x++){
            if(sender_id  != users[x]['id'] ){

                $('#' +users[x].id+'-status').removeClass('offline-status');
                $('#' +users[x].id+'-status').addClass('online-status');
                $('#' +users[x].id+'-status').text('Online');

            }
        }

    })
    .joining((user) => {

        $('#'+user.id+'-status').removeClass('offline-status');
        $('#'+user.id+'-status').addClass('online-status');
        $('#'+user.id+'-status').text('Online');

    })
    .leaving((user) => {

        $('#'+user.id+'-status').addClass('offline-status');
        $('#'+user.id+'-status').removeClass('online-status');
        $('#'+user.id+'-status').text('Offline');
    })
    .listen('UserStatusEvent',(e) => {
       // console.log('ffff'+e);
    });








