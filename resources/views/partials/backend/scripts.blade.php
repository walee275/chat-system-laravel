<!-- Bootstrap core JavaScript-->
<script src="{{ asset('new_template/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('new_template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('new_template/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('new_template/assets/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
{{-- <script src="{{ asset('new_template/assets/vendor/chart.js/Chart.min.js') }}"></script> --}}

{{-- <!-- Page level custom scripts -->
<script src="{{ asset('new_template/assets/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('new_template/assets/js/demo/chart-pie-demo.js') }}"></script> --}}
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script>
    $(document).ready(function() {



        getUnreadMessages();


        function getUnreadMessages() {
            fetch('{{ route('get.users_unread_messages') }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(function(response) {
                return response.json();
            }).then(function(result) {
                let output = '';
                let previousMsg = 0;
                $('#total-unread-msgs-count').text(result.total_msgs_received);

                result.messages.forEach(msg => {

                    if (msg.sender_id != previousMsg) {
                        output = `<a class="dropdown-item d-flex align-items-center"
                            href="{{ route('home') }}/individual-chat/show/${msg.sender.id}">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle"
                                    src="{{ asset('new_template/assets/img/undraw_profile_1.svg') }}" alt="...">
                                <div class="status-indicator bg-success"></div>
                            </div>
                            <div class="font-weight-bold">
                                <div class="text-truncate">${msg.sender.name}</div>
                                <div class="small text-gray-500">${strLimit(msg.message, 15, '...')}</div>
                            </div>
                            <span class="text-end ml-5">${result.unreadMessagesCountBySender[msg.sender.id]} Unread Messages</span>
                        </a> `;


                        previousMsg = msg.sender.id;
                        $('#unread-msgs-droplist').empty();
                        $('#unread-msgs-droplist').append(output);


                    } else {}
                });

            })
        }


        function strLimit(str, limit, suffix = '...') {
            if (str.length <= limit) {
                return str;
            }

            return str.slice(0, limit) + suffix;
        }


        let pusher = new Pusher('29e668d882ce376a7733', {
            cluster: 'ap2',
            encrypted: true
        });
        let messageReceivedChannel = pusher.subscribe('message-received');
        messageReceivedChannel.bind('App\\Events\\MessageReceivedEvent', function(data) {
            if (data.messageReceived && data.messageType == 'individual message') {
                getUnreadMessages();
            } else {
                console.log(data);
                output = `<a class="dropdown-item d-flex align-items-center"
                            href="{{ route('home') }}/individual-chat/show/">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle"
                                    src="{{ asset('new_template/assets/img/undraw_profile_1.svg') }}" alt="...">
                                <div class="status-indicator bg-success"></div>
                            </div>
                            <div class="font-weight-bold">
                                <div class="text-truncate">${data.messageType}</div>
                                <div class="small text-gray-500">${data.messageReceived.sender.name + ':'+ strLimit(data.messageReceived.message, 15, '...')}</div>
                            </div>
                            <span class="text-end ml-5">You Unread Messages in Global chat</span>
                        </a> `;
                $('#unread-msgs-droplist').append(output);
            }

        });










    })
</script>

@yield('scripts')

{{-- Message Seen Function Defined --}}
<script>
    // Messag Seen Function

    function messageSeen(MessagesIds, user) {

        fetch('{{ route('message_read_by_add') }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _token: '{{ csrf_token() }}',
                messages_read: MessagesIds,
                user_id: user
            })
        }).then(function(response) {
            return response.json();
        }).then(function(result) {})
    }





    // $(document).ready(function() {
    //     // Make a GET request to a service that returns the user's IP address
    //     $.get("https://api.ipify.org?format=json", function(data) {
    //         // Handle the response and display the user's IP address
    //         $.get("https://freegeoip.app/json/" + data.ip, function(data) {
    //             // Handle the response and display the result
    //             $.get(`https://geocode.maps.co/reverse?lat=${data.latitude}&lon=${data.longitude}`,
    //                 function(data) {
    //                     consoel.log(data.address.country);
    //                 });
    //             console.log("Country: " + data.country_name + "City: " + data.city)
    //             $("#ipAddress").html("Country: " + data.country_name + "<br>City: " + data
    //             .city);
    //         });
    //         // $("#ipAddress").html("Your IP Address: " + data.ip);
    //     });



    // });
</script>
