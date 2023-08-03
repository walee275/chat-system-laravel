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
            margin-bottom: 5px;
        }

        .message-timestamp {
            font-size: 12px;
            color: #888888;
        }


        /* For WebKit browsers (Chrome, Safari) */
        #message-container::-webkit-scrollbar-track {
            background-color: transparent;
        }
    </style>
@endsection

@section('admin-content')
    <div class="main-content-inner" style="padding: 13px;">

        <div class="row">
            <div class="col">
                <h3 class="text-center">Global Chat </h3>
                <div id="message-container" class="bg-light"
                    style="width: 64%;
                margin: auto; max-height:600px; overflow-y: auto;">
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
        let user = '{{ Auth::id() }}';
        show_messages(user);
        const readMessagesIds = [];


        function show_messages(user) {
            let sentMessageElement = '';
            let rcvdMessageElement = '';
            let output = '';
            fetch(`{{ route('global_chat') }}`, {
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

                    if (message.sender_id == user) {
                        output += `<div class="message sent">
                                        <div class="message-content">
                                            <span class="message-text">${message.message}</span>
                                            <span class="message-timestamp ml-3">${formattedDate}</span>
                                        </div>
                                    </div>`;
                    } else {
                        output += `<div class="message received">
                                        <div class="message-content">
                                            <div class="message-icon mb-1">${message.sender.name}</div>
                                            <span class="messaged">${message.message}</span>
                                            <span class="message-timestamp ml-3">${formattedDate}</span>
                                        </div>
                                    </div>`;
                    }
                readMessagesIds.push(message.id);
                });
                $("#message-container").html(output);

                if (readMessagesIds.length > 0) {
                        messageSeen(readMessagesIds,user);
                    }
            });
        }






        const sendMessageForm = $("#send_message_form");
            sendMessageForm.submit(function(e) {
                e.preventDefault();
                sendMessage();

                $(this).find('#message-text').val("");
        });

        function sendMessage() {
            if ($("#message-text").val() == '') {
                alert("Message cannot be empty");
                return;
            }

            const data = {
                _token: '{{ csrf_token() }}',
                message: $("#message-text").val()
            }
            fetch('{{ route('send_global_message') }}', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                if (result.success) {
                    show_messages(user);
                }
            });
        }


        var pusher = new Pusher('29e668d882ce376a7733', {
            cluster: 'ap2',
            encrypted: true
        });



        var channel = pusher.subscribe('message-received');
        channel.bind('App\\Events\\MessageReceivedEvent', function(data) {
            if(data.messageType == 'global message'){
                show_messages(user);
            }

        });


    </script>
@endsection
