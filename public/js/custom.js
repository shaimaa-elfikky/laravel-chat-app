    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $('.user-list').click(function(){

            $('#chat-container').empty();

            var getUserId = $(this).attr('data-id');

            receiver_id = getUserId  ;
            $('.start-head').hide();
            $('.chat-section').show();

    });




//save messages work

    $('#chat-form').submit(function(e){

        e.preventDefault();

        var message = $('#message').val();

            $.ajax({
                url:"/save-message",
                type:"POST",
                data : {sender_id :sender_id,
                    receiver_id:receiver_id,
                    message:message
                    },
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },

                success:function(res){

                if(res.success){

                    $('#message').val('');

                    let chatMessage = res.data && res.data.message ? res.data.message : message;

                    let html = `<div class="current-user-chat">
                                    <h5>${chatMessage}</h5>
                                </div>` ;
                                $('#chat-container').append(html);
                }else{

                     alert(res.msg);

                }

                },error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error sending message!');
                }

        });
    });


        window.Echo.private('broadcast-message')
        .listen('.getChatMessage', (data) => {

            if(sender_id == data.message.receiver_id && receiver_id == data.message.sender_id)
            {
                let html = `<div class="distance-user-chat">
                <h5>${data.message.message}</h5>
                   </div>`;
                 $('#chat-container').append(html);

            }

        });

});





