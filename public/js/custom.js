$(document).ready(function() {
    // Set CSRF token globally for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });



    // Load messages when a user is selected
    $('.user-list').click(function() {
        $('#chat-container').empty();
        receiver_id = $(this).attr('data-id');
        $('.start-head').hide();
        $('.chat-section').show();
        loadMessages();
    });

    // Save message
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        const message = $('#message').val();

        $.ajax({
            url: "/save-message",
            type: "POST",
            data: { sender_id, receiver_id, message },
            success: function(res) {
                if (res.success) {
                    $('#message').val('');
                    appendMessage(res.data, 'current-user-chat');
                    scrollCheck();
                } else {
                    alert(res.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error sending message!');
            }
        });
    });

    // Listen for new messages in real-time
    window.Echo.private('broadcast-message')
        .listen('.getChatMessage', (data) => {
            if (sender_id == data.message.receiver_id && receiver_id == data.message.sender_id) {
                appendMessage(data.message, 'distance-user-chat');
                scrollCheck();
            }
        });

    // Delete message
    $(document).on('click', '.fa-trash', function() {
        const id = $(this).attr('data-id');
        $('#delete-message-id').val(id);
        $('#delete-message').text($(this).siblings('span').text());
    });

    $('#delete-chat-form').submit(function(e) {
        e.preventDefault();
        const id = $('#delete-message-id').val();

        $.ajax({
            url: "/message-deleted",
            type: "POST",
            data: { id },
            success: function(res) {
                if (res.success) {
                    $(`#${id}-chatMessage, #${id}-message`).remove();
                    $('#deleteChatModal').modal('hide');
                }
                alert(res.msg);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error deleting message!');
            }
        });
    });

    // Listen for deleted messages in real-time
    window.Echo.private('deleted-message')
        .listen('MessageDeletedEvent', (data) => {
            $(`#${data.id}-chatMessage, #${data.id}-message`).remove();
        });

    // Update message
    $(document).on('click', '.fa-edit', function() {
        $('#update-message-id').val($(this).attr('data-id'));
        $('#update-message').val($(this).attr('data-msg'));
    });

    $('#update-chat-form').submit(function(e) {
        e.preventDefault();
        const id = $('#update-message-id').val();
        const msg = $('#update-message').val();

        $.ajax({
            url: "/update-message",
            type: "POST",
            data: { id, message: msg },
            success: function(res) {
                if (res.success) {
                    $('#updateChatModal').modal('hide');
                    $(`#${id}-message`).find('span').text(msg);
                    $(`#${id}-message`).find('.fa-edit').attr('data-msg', msg);
                } else {
                    alert(res.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error updating message!');
            }
        });
    });

    // Load messages
    function loadMessages() {
        $.ajax({
            url: "/load-messages",
            type: "POST",
            data: { sender_id, receiver_id },
            success: function(res) {
                if (res.success) {
                    $('#chat-container').empty();
                    res.data.forEach(message => {
                        const addClass = (message.sender_id == sender_id) ? 'current-user-chat' : 'distance-user-chat';
                        appendMessage(message, addClass);
                    });
                    scrollCheck();
                } else {
                    alert(res.msg);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error loading messages!');
            }
        });
    }

    // Append a message to the chat container
    function appendMessage(message, className) {
        let html = `<div class="${className}" id="${message.id}-message">
                        <h5><span>${message.message}</span>`;
        if (className === 'current-user-chat') {
            html += `<i class="fa fa-trash" aria-hidden="true" data-bs-toggle="modal" data-id="${message.id}" data-bs-target="#deleteChatModal"></i>
                     <i class="fa fa-edit" aria-hidden="true" data-bs-toggle="modal" data-id="${message.id}" data-msg="${message.message}" data-bs-target="#updateChatModal"></i>`;
        }
        html += `</h5></div>`;
        $('#chat-container').append(html);
    }

    // Scroll to the bottom of the chat container
    function scrollCheck() {
        $('#chat-container').animate({
            scrollTop: $('#chat-container')[0].scrollHeight
        }, 0);
    }
});