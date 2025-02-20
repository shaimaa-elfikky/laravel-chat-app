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

            loadMessages();

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

                    let html = `<div class="current-user-chat" id="${res.data.id}-chatMessage">
                                    <h5><span>${chatMessage}
                                    </span>
                                    <i class="fa fa-trash" aria-hidden="true" data-bs-toggle="modal"data-id="${res.data.id}" data-bs-target="#deleteChatModal"></i>
                                    </h5>
                                </div>` ;
                            $('#chat-container').append(html);
                            scrollCheck();
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
                let html = `<div class="distance-user-chat" id="${data.message.id}-message">
                <h5>${data.message.message}</h5>
                   </div>`;
                 $('#chat-container').append(html);
                 scrollCheck();

            }

        });


    $(document).on('click','.fa-trash',function(){
            var id = $(this).attr('data-id');
            $('#delete-message-id').val(id);
            $('#delete-message').text($(this).parent().text());
        });

        $('#delete-chat-form').submit(function(e){

            e.preventDefault();

            var id = $('#delete-message-id').val();
            console.log('Delete Clicked - ID:', id);

            $.ajax({

                url:"/message-deleted",
                type:"POST",
                data : {id :id
                        },
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },

                    success:function(res){
                        alert(res.msg);
                        if(res.success){
                            $('#' + id + '-chatMessage, #' + id + '-message').remove();
                            $('#deleteChatModal').modal('hide');

                        }
                    }
            });

        });

    });

 //load messages
    function loadMessages(){

        $.ajax({
            url:"/load-messages",
            type:"POST",
            data : {sender_id :sender_id,
                receiver_id:receiver_id,
                },
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },

                success:function(res){
                    if(res.success){

                        let messages = res.data ;

                        let html = '';
                        let addClass = ''
                        for(let i = 0 ; i < messages.length ; i ++)
                        {

                            if(messages[i].sender_id == sender_id ){
                                addClass = "current-user-chat" ;
                            }else{
                                addClass = "distance-user-chat"
                            }
                            html+= `<div class="${addClass}" id="${messages[i].id}-message">
                                    <h5><span>${messages[i].message}</span> `;
                                    if(messages[i].sender_id == sender_id ){
                                        html+=
                                     `<i class="fa fa-trash" aria-hidden="true" data-bs-toggle="modal"data-id="${messages[i].id}" data-bs-target="#deleteChatModal"></i>`;
                                    }

                                     html+=
                                   ` </h5>
                                </div>` ;
                        }
                        $('#chat-container').append(html);
                        scrollCheck();

                    }else{
                     alert(res.msg);
                    }
                }
            });


    }


    //function scroll check
    function scrollCheck()
    {
        $('#chat-container').animate({

            scrollTop:$('#chat-container').offset().top+$('#chat-container')[0].scrollHeight

        },0);
    }







