@extends('frontend.layouts.main')

@section('content')
    <main>
        <div class="container-fluid  p-3 pt-2 pb-0">
            <div class="row card-body shadow vh-100">
                <div class="col-md-3 border-end p-2 d-none d-md-block">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="text-capitalize fw-bold">Chats</h5>
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('storage/default-avatar.png') }}"
                                    alt class="rounded-circle" style="width:40px; height:40px;" />

                            </a>
                            {{ Auth::user()->name }}
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li class="dropdown-item text-capitalize fw-bold text-primary">{{ Auth::user()->name }}</a>
                                </li>
                                <li><a class="dropdown-item" href="#">My Profile</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search user" aria-label="Search">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-search"></i> <!-- Search icon -->
                        </button>
                    </div>
                    <ul class="list-group">
                        @foreach ($users as $user)
                            <li class="list-group-item {{ session('selectedUserId') == $user->id ? 'active' : '' }}"
                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                onclick="showUserChat('{{ $user->id }}', '{{ $user->name }}')">
                                <img src="{{ $user->avatar ? (filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : asset('storage/' . $user->avatar)) : asset('storage/default-avatar.png') }}"
                                    alt class="rounded-circle" style="width:40px; height:40px;" />
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="col-md-9 d-flex flex-column h-100" id="chatContent">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <h5> <img
                                src="{{ Auth::user()->avatar ? (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar)) : asset('storage/default-avatar.png') }}"
                                alt class="rounded-circle" style="width:40px; height:40px;" />
                            <span class="fw-bold text-dark" id="chatUserNameProfile"></span>
                        </h5>
                        <div class="d-flex ms-auto">
                            <!-- Voice Call Button -->
                            <button class="btn btn-outline-primary me-2" type="button" id="voiceCallBtn">
                                <i class="fas fa-phone"></i>
                            </button>
                            <!-- Video Call Button -->
                            <button class="btn btn-outline-primary me-2" type="button" id="videoCallBtn">
                                <i class="fas fa-video"></i>
                            </button>
                            <!-- Modal for Outgoing Video Call -->
                            @include('frontend.message.partials.video-outgoing')
                            <!-- Modal for Incoming Video Call -->
                            @include('frontend.message.partials.video-incoming')
                            <!-- More Options Button -->
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex-grow-1 border rounded p-3 overflow-auto text-wrap">
                        <div id="message-container"></div> <!-- This will contain all messages -->
                    </div>

                    <div class="chat-form border-top pt-3">
                        <div id="replyMessage" class="reply-message-container rounded p-1 mx-2 border"
                            style="display: none; height: auto;">
                            <strong id="replyMessageText" class="text-start"></strong>
                            <button id="closeReplyBtn" class="btn btn-link text-danger  text-decoration-none"> <i
                                    class="fa fa-times-circle" aria-hidden="true"></i></button>
                        </div>
                        <input type="hidden" id="messageInput" class="form-control rounded m-0"
                            placeholder="Type a message">

                        <input type="hidden" id="messageInput" class="form-control rounded m-0"
                            placeholder="Type a message">
                        <form class="d-flex align-items-center  w-100" id="chatForm">
                            <!-- File Input -->
                            <input type="file" id="fileInput" style="display: none;">
                            <label for="fileInput" class="btn btn-outline-primary m-1 mb-3">
                                <i class="fas fa-paperclip"></i> <!-- Attachment icon -->
                            </label>
                            <input type="text" name="message" id="chatInput" class="form-control mb-3 mx-3 m-2 "
                                placeholder="Type your message...">
                            <button type="button" class="btn btn-outline-primary m-2 mb-3 emoji-btn" id="emojiBtn">
                                <i class="fas fa-smile"></i> <!-- Emoji icon -->
                            </button>

                            <!-- Modal -->
                            @include('frontend.message.partials.emoji-modal')
                            <button type="button" class="btn btn-outline-primary m-2 mb-3" id="voiceBtn"
                                data-bs-toggle="modal" data-bs-target="#voiceModal">
                                <i class="fas fa-microphone"></i> <!-- Voice icon -->
                            </button>
                            <!-- Modal Structure -->

                            <button type="submit" class="btn btn-primary m-2 mb-3"> <i class="fa fa-paper-plane"
                                    aria-hidden="true"></i></button>
                        </form>
                    </div>
                    @include('frontend.message.partials.recording')
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <audio id="sendSound" src="{{ asset('sounds/send.mp3') }}"></audio>
    <audio id="receiveSound" src="{{ asset('sounds/receive.mp3') }}"></audio>

    {{-- <script>
        $(document).ready(function() {
            const sendSound = document.getElementById('sendSound');
            const receiveSound = document.getElementById('receiveSound');

            // Function to play sound
            function playSound(audioElement) {
                audioElement.currentTime = 0;
                audioElement.play().catch(error => console.log("Sound play blocked:", error));
            }

            // Handle sending a message
            $('#chatForm').on('submit', function(event) {
                event.preventDefault();

                const messageInput = document.querySelector('#chatForm input[type="text"]');
                const messageContainer = document.getElementById('message-container');
                const user_id_from = "{{ Auth::user()->id }}";
                const user_id_to = "{{ @$user->id }}";
                const messageText = messageInput.value.trim();

                if (messageText !== "") {
                    // Play send sound
                    playSound(sendSound);

                    // Create new message bubble for sent message
                    const messageWrapper = createMessageBubble('You', messageText, true);
                    messageContainer.appendChild(messageWrapper);
                    messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll to bottom

                    // Clear input
                    messageInput.value = '';

                    // Send the message to the backend via AJAX
                    $.ajax({
                        url: '{{ route('messages.store') }}', // Your endpoint to handle message storage
                        type: 'POST',
                        data: {
                            message: messageText, // Pass the message text
                            user_id_from: user_id_from, // Pass the user ID of the sender
                            user_id_to: user_id_to, // Pass the user ID of the recipient
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            console.log('Message sent successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error sending message:', error);
                        }
                    });
                }
            });

            // Listen for messages on the private channel
            window.Echo.private(`chat.{{ Auth::id() }}`)
                .listen('MessageSent', (data) => {
                    const messageContainer = document.getElementById('message-container');
                    const messageWrapper = createMessageBubble(data.message.user_id_from, data.message.message,
                        false);
                    messageContainer.appendChild(messageWrapper);
                    messageContainer.scrollTop = messageContainer.scrollHeight;

                    // Play receive sound
                    playSound(receiveSound);
                });

            // Function to create message bubble
            function createMessageBubble(userName, messageText, isSender) {
                const messageWrapper = document.createElement('div');
                messageWrapper.classList.add('mb-1', isSender ? 'text-end' : 'text-start', 'message-wrapper',
                    'position-relative');

                messageWrapper.innerHTML = `
                <h5><small class="text-muted" style="font-size: 14px;">${userName}</small></h5>
                <div class="hover-icons row d-flex align-items-center justify-content-${isSender ? 'end' : 'start'}">
                    <div class="hover-icons-actions d-flex col-2 justify-content-${isSender ? 'end' : 'start'} align-items-center">
                        <button class="btn btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item" onclick="deleteMessage(event)">Delete</button></li>
                        </ul>
                        <button class="btn btn-light" onclick="replyMessage(event)"><i class="fas fa-reply"></i></button>
                        <button class="btn btn-light" onclick="showEmojiPicker(event)"><i class="fas fa-heart"></i></button>
                    </div>
                    <div class="message ${isSender ? 'bg-primary' : 'bg-secondary'} p-2 rounded text-white col-4 text-wrap">
                        <p class="text-wrap mb-0">${messageText}</p>
                        <p class="text-white text-${isSender ? 'end' : 'start'} small mb-0 p-1" style="font-size: 10px;">${new Date().toLocaleTimeString()}</p>
                    </div>
                </div>
            `;
                return messageWrapper;
            }
        });
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <script>
        $(document).ready(function() {
            const sendSound = document.getElementById('sendSound');
            const receiveSound = document.getElementById('receiveSound');

            function playSound(audioElement) {
                audioElement.currentTime = 0;
                audioElement.play().catch(error => console.log("Sound play blocked:", error));
            }

            $('#chatForm').on('submit', function(event) {
                event.preventDefault();

                const messageInput = $('#chatInput');
                const messageContainer = $('#message-container');
                const messageText = messageInput.val().trim();
                const user_id_to = "{{ @$user->id }}";

                if (messageText !== "") {
                    playSound(sendSound);

                    const messageWrapper = createMessageBubble('You', messageText, true);
                    messageContainer.append(messageWrapper);
                    messageContainer.scrollTop(messageContainer[0].scrollHeight);

                    messageInput.val('');

                    $.ajax({
                        url: '{{ route('messages.store') }}',
                        type: 'POST',
                        data: {
                            message: messageText,
                            user_id_from: "{{ Auth::user()->id }}",
                            user_id_to: user_id_to,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('Message sent:', response);
                        },
                        error: function(xhr) {
                            console.error('Error sending message:', xhr);
                        }
                    });
                }
            });

            window.Echo.private(`chat.{{ Auth::id() }}`)
                .listen('MessageSent', (data) => {
                    const messageContainer = $('#message-container');
                    const messageWrapper = createMessageBubble(data.message.user_id_from, data.message.message,
                        false);
                    messageContainer.append(messageWrapper);
                    messageContainer.scrollTop(messageContainer[0].scrollHeight);
                    playSound(receiveSound);
                });

            function createMessageBubble(userName, messageText, isSender) {
                return `
                <div class="mb-1 text-${isSender ? 'end' : 'start'} message-wrapper position-relative">
                    <h5><small class="text-muted">${userName}</small></h5>
                    <div class="message bg-${isSender ? 'primary' : 'secondary'} p-2 rounded text-white">
                        <p class="mb-0">${messageText}</p>
                        <p class="text-white text-${isSender ? 'end' : 'start'} small mb-0 p-1" style="font-size: 10px;">
                            ${new Date().toLocaleTimeString()}
                        </p>
                    </div>
                </div>`;
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to show the chat for the selected user
            function showUserChat(userId, userName) {
                // Update the chat user name
                $('#chatUserNameProfile').text(userName);
                var newUrl = '/send-message/' + userId + '/' + encodeURIComponent(userName);
                history.pushState(null, null, newUrl);

                // Update URL without reloading the page
                var newUrl = '/chat/' + userId;

                // Make an AJAX request to load the chat for the selected user
                $.ajax({
                    url: newUrl,
                    method: 'GET',
                    success: function(response) {
                        $('#message-container').html(response);

                        // Scroll to the bottom of the chat container
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Utility function to scroll to the bottom of the message container
            function scrollToBottom() {
                const messageContainer = $('#message-container');
                messageContainer.scrollTop(messageContainer[0].scrollHeight);
            }

            // When a user is clicked in the list
            $('.list-group-item').on('click', function() {
                // Remove 'active' class from any previously active user
                $('.list-group-item').removeClass('active');

                // Add 'active' class to the currently clicked user
                $(this).addClass('active');

                // Retrieve user ID and name from data attributes
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');

                // Store the selected user in local storage
                localStorage.setItem('selectedUserId', userId);
                localStorage.setItem('selectedUserName', userName);

                // Show the chat for the clicked user
                showUserChat(userId, userName);
            });

            // On page load, check if there's a selected user in local storage
            var selectedUserId = localStorage.getItem('selectedUserId');
            var selectedUserName = localStorage.getItem('selectedUserName');

            if (selectedUserId && selectedUserName) {
                // Find the corresponding list item and set it as active
                $('.list-group-item').each(function() {
                    if ($(this).data('user-id') == selectedUserId) {
                        $(this).addClass('active');
                    }
                });

                // Load the chat for the selected user
                showUserChat(selectedUserId, selectedUserName);
            }
        });
    </script>


    {{-- <script>
        $(document).ready(function() {
            // Initially show only the latest 20 messages
            let messagesPerBatch = 20;
            let messageWrappers = $('.message-wrapper');
            let totalMessages = messageWrappers.length;

            // Hide all messages except the latest batch
            if (totalMessages > messagesPerBatch) {
                messageWrappers.slice(0, totalMessages - messagesPerBatch).hide();
            }

            // Track the current number of visible messages
            let visibleMessagesCount = messagesPerBatch;

            // Scroll to bottom to show the latest messages initially
            scrollToBottom();

            // Function to scroll to the bottom of the message container
            function scrollToBottom() {
                const messageContainer = $('#message-container');
                messageContainer.scrollTop(messageContainer[0].scrollHeight);
            }

            // Detect scroll to the top to reveal more messages
            $('#message-container').on('scroll', function() {
                if ($(this).scrollTop() === 0) {
                    // If we're at the top of the container, reveal more messages
                    const remainingMessages = totalMessages - visibleMessagesCount;
                    const batchToShow = Math.min(remainingMessages, messagesPerBatch);

                    if (batchToShow > 0) {
                        // Show the next batch of hidden messages
                        messageWrappers.slice(visibleMessagesCount - batchToShow, visibleMessagesCount)
                            .show();

                        // Update the count of visible messages
                        visibleMessagesCount += batchToShow;

                        // Adjust scroll position to maintain the user's view
                        const messageContainer = $('#message-container');
                        messageContainer.scrollTop(messageContainer[0].scrollHeight /
                            2); // Adjust as needed to avoid jump
                    }
                }
            });

            // Handle sending a message
            $('#chatForm').on('submit', function(event) {
                event.preventDefault();

                const messageInput = document.querySelector('#chatForm input[type="text"]');
                const messageContainer = document.getElementById('message-container');
                const user_id_from = "{{ Auth::user()->id }}";
                const user_id_to = "{{ @$user->id }}";
                const messageText = messageInput.value;

                if (messageText.trim() !== "") {
                    // Create new message bubble for sent message
                    const messageWrapper = createMessageBubble('You', messageText, true);
                    messageContainer.appendChild(messageWrapper);
                    messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll to bottom

                    // Clear input
                    messageInput.value = '';

                    // Send the message to the backend via AJAX
                    $.ajax({
                        url: '{{ route('messages.store') }}', // Your endpoint to handle message storage
                        type: 'POST',
                        data: {
                            message: messageText, // Pass the message text
                            user_id_from: user_id_from, // Pass the user ID of the sender
                            user_id_to: user_id_to, // Pass the user ID of the recipient
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            // Handle success response
                            console.log('Message sent successfully:', response);
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error('Error sending message:', error);
                        }
                    });
                }
            });

            // Function to create message bubble
            function createMessageBubble(userName, messageText, isSender) {
                const messageWrapper = document.createElement('div');
                messageWrapper.classList.add('mb-1', isSender ? 'text-end' : 'text-start', 'message-wrapper',
                    'position-relative');

                messageWrapper.innerHTML = `
            <h5><small class="text-muted" style="font-size: 14px;">${userName}</small></h5>
            <div class="hover-icons row d-flex align-items-center justify-content-${isSender ? 'end' : 'start'}">
                <div class="hover-icons-actions d-flex col-2 justify-content-${isSender ? 'end' : 'start'} align-items-center">
                    <button class="btn btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" onclick="deleteMessage(event)">Delete</button></li>
                    </ul>
                    <button class="btn btn-light" onclick="replyMessage(event)"><i class="fas fa-reply"></i></button>
                    <button class="btn btn-light" onclick="showEmojiPicker(event)"><i class="fas fa-heart"></i></button>
                </div>
                <div class="message ${isSender ? 'bg-primary' : 'bg-secondary'} p-2 rounded text-white col-4 text-wrap">
                    <p class="text-wrap mb-0">${messageText}</p>
                    <p class="text-white text-${isSender ? 'end' : 'start'} small mb-0 p-1" style="font-size: 10px;">${new Date().toLocaleTimeString()}</p>
                </div>
            </div>
        `;
                return messageWrapper;
            }
        });
    </script>
   

    <script>
        $(document).ready(function() {
            // Listen for messages on the private channel
            window.Echo.private(`chat.{{ Auth::id() }}`)
                .listen('MessageSent', (data) => {
                    const messageContainer = document.getElementById('message-container');
                    const messageWrapper = createMessageBubble(data.message.user_id_from, data.message.message,
                        false);
                    messageContainer.appendChild(messageWrapper);
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                });

            // Rest of your existing JavaScript code...
        });
    </script> --}}
@endsection
