@extends('layouts.backend.main')

@section('title', 'Messages')

@section('styles')
    <style>
        {
            box-sizing: border-box;
        }

        /* Button used to open the chat form - fixed at the bottom of the page */
        .open-button {
            background-color: #555;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            opacity: 0.8;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 280px;
        }

        /* The popup chat - hidden by default */
        .form-popup {
            display: none;
            position: fixed;
            bottom: 0;
            right: 15px;
            border: 3px solid #f1f1f1;
            z-index: 9;
        }

        /* Add styles to the form container */
        .form-container {
            max-width: 300px;
            padding: 10px;
            background-color: white;
        }

        /* Full-width textarea */
        .form-container textarea {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
            resize: none;
            min-height: 200px;
        }

        /* When the textarea gets focus, do something */
        .form-container textarea:focus {
            background-color: #ddd;
            outline: none;
        }

        /* Set a style for the submit/login button */
        .form-container .btn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        /* Add a red background color to the cancel button */
        .form-container .cancel {
            background-color: red;
        }

        /* Add some hover effects to buttons */
        .form-container .btn:hover,
        .open-button:hover {
            opacity: 1;
        }

        #new_msg_btn {
            position: fixed;
            bottom: 10%;
            left: 88%;

        }

        #compose_message_modal {
            position: absolute;
            bottom: 15%;
            left: 78%;

        }
    </style>
@endsection



@section('admin-content')


    <!-- Messages -->
    <div class=" shadow " style="max-height:fit-content;">
        <h6 class="dropdown-header text-center">
            Message Center
        </h6>
        <div id="">
            @php
                $prevuser = [];
            @endphp
            @foreach ($messages as $msg)
                @if ($msg->receiver && $msg->receiver->id != Auth::id() && !in_array($msg->receiver->id, $prevuser))
                    <a class="dropdown-item d-flex align-items-center mb-2 text-white"
                        style="background-color: #e4e7ff!important; color: #5f5555!important;"
                        href="{{ route('individual_chat.show', $msg->receiver) }}">
                        <div class=" mr-3" style="width: 60px!important;">
                            <img class="rounded-circle" src="{{ asset('new_template/assets/img/undraw_profile.svg') }}"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">{{ $msg->receiver->name }}</div>
                            <div class="small text-gray-500">{{ $msg->message }}</div>
                        </div>
                        <span class="text-end ml-auto"> Messages</span>
                    </a>

                    @php
                        $prevuser[] = $msg->receiver->id;
                    @endphp
                @endif
            @endforeach

        </div>


        <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
    </div>

    <button onclick="openForm()" class="btn btn-info" id="new_msg_btn">Compose message</button>

    <div id="compose_message_modal" class="card d-none">
        <div class="card-header d-flex" style="">
            <h1>Chat</h1>
            <button type="close" class=" btn-close border-0 ml-auto" onclick="openForm()">X</button>
        </div>
        <div class="card-body">
            <div class="chat-popup ">
                <div id="error"></div>
                <form class="form-container" id="myForm">
                    <label for="recipient_email"><b>Recipient</b></label>
                    <input type="email" class="form-control" name="recipient_email" id="recipient_email"
                        placeholder="Enter recipient email..">
                    <label for="msg"><b>Message</b></label>
                    <textarea placeholder="Type message.." name="msg" id="msg" required></textarea>

                    <button type="submit" class="btn">Send</button>
                </form>
            </div>
        </div>


    </div>



@endsection

@section('scripts')
    <script>
        function openForm() {
            $("#compose_message_modal").toggleClass('d-none');
        }


        $(document).ready(function() {


            $('#myForm').on('submit', function(e) {
                e.preventDefault();
                const email = $('#recipient_email').val();
                const msg = $('#msg').val();
                const data = {
                    _token: '{{ csrf_token() }}',
                    email: email,
                    message: msg,
                }
                fetch('{{ route('send_new_message') }}', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    if (result.success) {
                        $('#recipient_email').val("");
                        $('#msg').val("");
                        $('#error').html(`<div class="alert alert-success">${result.message}</div>`)
                    } else {
                        $('#error').html(`<div class="alert alert-danger">${result.message}</div>`)
                    }
                })
            })
        });
    </script>
@endsection












{{--
             --}}
