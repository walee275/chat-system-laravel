@extends('layouts.backend.main')

@section('title', 'Messages')

@section('styles')
    <style>
        .message {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 10px;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-icon {
            font-size: 12px;
        }

        .message-content {
            max-width: 70%;
            padding: 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
        }

        .message.sent .message-content {
            background-color: #e2f0ff;
        }

        .message-text {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 5px;
            padding: 20px;


        }

        .message-timestamp {
            font-size: 10px;
            color: #888888;
            text-align: end;
            margin-top: 8px;
        }


        /* For WebKit browsers (Chrome, Safari) */
        #message-container::-webkit-scrollbar-track {
            background-color: transparent;
        }

        .read-tick {
            /* position: absolute; */
            /* bottom: 0; */
            /* right: -20px; */
            color: green;
            font-size: 14px;
        }
    </style>
@endsection

@section('admin-content')
    <div class="main-content-inner" style="padding: 13px;">
        <div class="row">
            <div class="col px-4" style="text-align: end;"><a href="{{ route('get_all_individual_chats') }}"
                    class="btn btn-dark">Back</a></div>
        </div>
        <div class="row">
            <div class="col">
                <h3 class="text-center">Chat with {{ $receiver->name }}</h3>
                <div id="message-container" class="bg-light"
                    style="width: 64%;
                        margin: auto; max-height:600px; overflow-y: auto;">
                    {{-- @foreach ($messages as $message)
                        <!-- Message 1 -->
                        @php
                            $receiverInitials =  'U4';
                            $senderInitials = 'Wk';
                        @endphp
                        @if ($message->sender_id === Auth::id())
                            <div class="message sent">
                                <div class="message-content">
                                    <div class="message-icon">{{ $senderInitials }}</div>
                                    <span class="message-text">{{ $message->message }}</span>
                                    <span
                                        class="message-timestamp">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                        @else
                            <!-- Message 2 -->
                            <div class="message received">
                                <div class="message-content">
                                    <div class="message-icon">{{ $receiverInitials }}</div>
                                    <span class="message-text">{{ $message->message }}</span>
                                    <span
                                        class="message-timestamp">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i A') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach --}}



                    <!-- Message 2 -->
                    {{-- <div class="message received">
                        <div class="message-content">
                            <span class="message-text">This is the received message</span>
                            <span class="message-timestamp">10:01 AM</span>
                        </div>
                    </div> --}}

                    <!-- Add more messages here -->
                </div>
                <div class="" style="margin:auto; width: 64%!important;">

                    <form action="" id="send_message_form" style="width: 100%;">
                        <div class="input-group">
                            <input type="text" class="form-control border-radius-0" style="height: 6vh;"
                                id="message-text" placeholder="Type Message here!">

                            <!-- Dropzone file input -->
                            {{-- <div id="dropzone" class="dropzone"></div> --}}

                            <div class="input-group-append">
                                <button type="submit" id="send_message_btn" class="btn btn-primary"
                                    style="border-radius: 0.25rem !important;">Send</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection
@section('scripts')

    <script>
        $(document).ready(function() {

            $('#message-container').scrollTop($('#message-container')[0].scrollHeight);
            let rcvr = '{{ $receiver->id }}';
            let sndr = '{{ Auth::id() }}';

            window.addEventListener('focus', function() {
                // console.log('Page is now in focus (unminimized)');
                show_messages(sndr, rcvr);

            });



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
                        messageSeen(readMessagesIds, sndr);
                    }


                });
            }






            const sendMessageForm = $("#send_message_form");
            sendMessageForm.submit(function(e) {
                e.preventDefault();
                sendMessage(rcvr);
            })

            function sendMessage(recipient) {
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


            let channel = pusher.subscribe('message-received');
            channel.bind('App\\Events\\MessageReceivedEvent', function(data) {
                if (data.messageReceived.receiver_id == sndr && data.messageType == 'individual message') {
                    const createdAt = new Date(data.messageReceived
                        .created_at); // Replace with your actual created_at timestamp

                    const formattedDate = createdAt.toLocaleString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                    });
                    $('#message-container').append(`<div class="message received">
                                        <div class="message-content">
                                            <span class="message-text">${data.messageReceived.message}</span>
                                            <span class="message-timestamp fs-small">${formattedDate}</span>
                                        </div>
                                    </div>`);
                    let messageId = [];
                    messageId.push(data.messageReceived.id);
                    if (isUserActive()) {
                        messageSeen(messageId, data.messageReceived.receiver_id);
                    } else {
                        console.log('úser is not active')
                    }

                }
            });

            channel = pusher.subscribe('message-seen');
            channel.bind('App\\Events\\MessageSeenEvent', function(data) {
                if (data.userId == rcvr) {
                    const messageBox = $(`#message-container .message${data.messageId}-box`);

                    if (messageBox.length) {
                        messageBox.find('.read-tick').html('&#10003;&#10003;');
                    } else {
                        $(`#message-container .message${data.messageId}-box`).append(
                            '<span class="read-tick">&#10003;&#10003;</span>');
                    }


                }
            });





            function isUserActive() {
                return !document.hidden;
            }


        })
    </script>
@endsection
