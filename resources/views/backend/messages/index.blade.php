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
            </div>
        </div>

    </div>

@endsection
@section('scripts')
    <script>
        let user = '{{ Auth::id() }}';
        show_messages(user);



        function show_messages(user) {
            let sentMessageElement = '';
            let rcvdMessageElement = '';
            let output = '';
            fetch(`{{ route('global_chat') }}`, {
                method: 'GET'
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                // console.log(result);
                let rcpnt = '';
                result.forEach(message => {
                    if (message.sender_id == user) {
                        output += `<div class="message sent">
                                        <div class="message-content">
                                            <div class="message-icon">${message.sender.name}</div>
                                            <span class="message-text">${message.message}</span>
                                            <span class="message-timestamp"></span>
                                        </div>
                                    </div>`;
                    } else {
                        // rcpnt = message.
                        output += `<div class="message received">
                                        <div class="message-content">
                                            <div class="message-icon">${message.sender.name}</div>
                                            <span class="message-text">${message.message}</span>
                                            <span
                                                class="message-timestamp"></span>
                                        </div>
                                    </div>`;
                    }
                });

                output += `<div class="row m-0 my-3 p-0">
                                <div class="col">
                                    <div class="input-group">
                                    <input type="text" class="form-control border-radius-0 " style="height: 6vh;" id="message-text" placeholder="Type Message here!">
                                    <button id="send_message_btn" onClick="sendMessage()" class="btn btn-primary" style="border-radius: 0.25rem !important;">Send</button>
                                    </div>
                                </div>
                            </div>`;

                $("#message-container").html(output);
                console.log($("#message-container"));
            });
        }






        const sendMessageForm = $("#send_message_form");

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

        // var channel = pusher.subscribe('test-channel');
        // channel.bind('App\\Events\\TestEvent', function(data) {
        //     console.log('Message received: ' + data.message);
        // });

        var channel = pusher.subscribe('global-message-channel');
        channel.bind('App\\Events\\GlobalMessageEvent', function(data) {
            // if (data.receiverId == user) {
                show_messages(user);
            // }
            console.log(data);
            // console.log('New Message Recieved: ' + data.messageContent);
            // console.log('New Message Recieved From: ' + data.sender_name);
        });


    </script>
@endsection
