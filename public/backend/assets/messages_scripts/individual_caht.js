$(document).ready(function() {
    $('#message-container').scrollTop($('#message-container')[0].scrollHeight);
    let rcvr = '{{ $receiver->id }}';
    let sndr = '{{ Auth::id() }}';
    show_messages(sndr, rcvr);
    const readMessagesIds = [];



    function show_messages(sender, receiver) {
        let sentMessageElement = '';
        let rcvdMessageElement = '';
        let output = '';
        fetch(`{{ route('individual_chat.get', $receiver) }}`, {
            method: 'GET'
        }).then(function(response) {
            return response.json();
        }).then(function(result) {
            let rcpnt = '';
            result.forEach(message => {

                const createdAt = new Date(message
                    .created_at); // Replace with your actual created_at timestamp

                const formattedDate = createdAt.toLocaleString('en-US', {
                    hour: 'numeric',
                    minute: 'numeric',
                });

                let isMessageRead = '';

                if (message.message_reads.length > 0) {
                    if (message.message_reads[0].id == rcvr) {

                        isMessageRead = '<span class="read-tick ">&#10003;&#10003;</span>';
                    }
                } else {

                    isMessageRead =
                        '<div class="read-tick " style="text-align:end!important;">&#10003;</div>';
                }
                if (message.sender_id == sender) {
                    output += `<div class="message sent">
                                <div class="message-content message${message.id}-box">
                                    <span class="message-text">${message.message}</span>
                                    <span class="message-timestamp ">${formattedDate}</span>
                                    ${isMessageRead}
                                </div>
                            </div>`;
                } else {
                    output += `<div class="message received">
                                <div class="message-content">
                                    <span class="message-text">${message.message}</span>
                                    <span class="message-timestamp fs-small">${formattedDate}</span>
                                </div>
                            </div>`;
                    readMessagesIds.push(message.id);
                }



            });

            $("#message-container").html(output);

            if (readMessagesIds.length > 0) {
                messageSeen(readMessagesIds);
            }


        });
    }






    const sendMessageForm = $("#send_message_form");

    function sendMessage(recipient = rcvr) {
        if ($("#message-text").val() == '') {
            alert("Message cannot be empty");
            return;
        }

        const data = {
            _token: '{{ csrf_token() }}',
            recipient: recipient,
            message: $("#message-text").val()
        }
        fetch('{{ route('send_individual_message') }}', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(function(response) {
            return response.json();
        }).then(function(result) {
            if (result.success) {
                $('#message-text').val("");

                show_messages(sndr, rcvr);
            }
        });
    }


    let pusher = new Pusher('29e668d882ce376a7733', {
        cluster: 'ap2',
        encrypted: true
    });


    let channel = pusher.subscribe('individual-message-channel');
    channel.bind('App\\Events\\IndividualMessageEvent', function(data) {
        if (data.message.receiver_id == sndr) {
            const createdAt = new Date(data.message
                .created_at); // Replace with your actual created_at timestamp

            const formattedDate = createdAt.toLocaleString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
            });
            $('#message-container').append(`<div class="message received">
                                <div class="message-content">
                                    <span class="message-text">${data.message.message}</span>
                                    <span class="message-timestamp fs-small">${formattedDate}</span>
                                </div>
                            </div>`);
            let messageId = [];
            messageId.push(data.message.id);
            messageSeen(messageId);
        }
        console.log(data);
    });

    channel = pusher.subscribe('message-seen');
    channel.bind('App\\Events\\MessageSeenEvent', function(data) {
        if (data.userId == rcvr) {
            // show_messages(sndr, rcvr);
            const messageBox = $(`#message-container .message${data.messageId}-box`);

            if (messageBox.length) {
                messageBox.find('.read-tick').html('&#10003;&#10003;');
            } else {
                $(`#message-container .message${data.messageId}-box`).append(
                    '<span class="read-tick">&#10003;&#10003;</span>');
            }


        }
        console.log(data);
        // console.log('New Message Recieved: ' + data.messageContent);
        // console.log('New Message Recieved From: ' + data.sender_name);
    });



    // Messag Seen Function

    function messageSeen(MessagesIds) {

        fetch('{{ route('message_read_by_add') }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}',
                messages_read: MessagesIds,
                user_id: sndr
            })
        }).then(function(response) {
            return response.json();
        }).then(function(result) {
            console.log(result);
        })
    }

    function isUserActive() {
        return !document.hidden;
    }

})
