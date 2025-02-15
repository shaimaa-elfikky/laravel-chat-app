
$(document).ready(function(){
    $('.user-list').click(function(){

        $('.start-head').hide();
        $('.chat-section').show();

    })
})




// Echo.join('status-update')
//     .here((users) => {
//         console.log(users);
//     })
//     .joining((user) => {
//         //console.log(user.name);
//     })
//     .leaving((user) => {
//         //console.log(user.name);
//     })
//     .listen('UserStatusEvent',(e) => {
//         //console.log(e);
//     });