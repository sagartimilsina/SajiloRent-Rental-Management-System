@extends('layouts.main')

@section('section')
    <main>
        <div class="container-fluid  p-3 pt-2 pb-0 ">
            <div class="row card-body shadow">
                <div class="col-md-3 border-end p-2 d-none d-md-block">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="text-capitalize fw-bold">Chats</h5>
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=0&k=20&c=yBeyba0hUkh14_jgv1OKqIH0CCSWU_4ckRkAoy2p73o="
                                    class="img-fluid rounded-circle me-2" width="40" height="40" alt="Profile">
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
                                <img src="https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=0&k=20&c=yBeyba0hUkh14_jgv1OKqIH0CCSWU_4ckRkAoy2p73o="
                                    class="img-fluid rounded-circle d-inline-block me-2" width="40" alt="User Image" />
                                {{ $user->name }}
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class="col-md-9 d-flex flex-column h-100" id="chatContent">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <h5><img src="https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=0&k=20&c=yBeyba0hUkh14_jgv1OKqIH0CCSWU_4ckRkAoy2p73o="
                                class="img-fluid rounded-circle d-inline-block me-2" width="40" alt="" />
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
                            <div class="modal fade" id="outgoingVideoCallModal" tabindex="-1"
                                aria-labelledby="outgoingVideoCallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="outgoingVideoCallModalLabel">Outgoing Video Call
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <video id="localVideo" autoplay playsinline
                                                style="width: 100%; border: 1px solid #ccc; border-radius: 8px;"></video>
                                            <p>Calling...</p>
                                            <audio id="outgoingVideoRingingAudio" src="ringing.mp3" loop></audio>
                                            <div class="mt-3">
                                                <i class="fas fa-phone-slash text-danger" id="endOutgoingVideoCall"
                                                    style="cursor: pointer; font-size: 24px;" title="End Call"></i>
                                                <i class="fas fa-microphone-slash text-secondary" id="muteVideo"
                                                    style="cursor: pointer; font-size: 24px;" title="Mute Video"></i>
                                                <i class="fas fa-video-slash text-secondary" id="turnOffCamera"
                                                    style="cursor: pointer; font-size: 24px;" title="Turn Off Camera"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal for Incoming Video Call -->
                            <div class="modal fade" id="incomingVideoCallModal" tabindex="-1"
                                aria-labelledby="incomingVideoCallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="incomingVideoCallModalLabel">Incoming Video
                                                Call</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <video id="remoteVideo" autoplay playsinline
                                                style="width: 100%; border: 1px solid #ccc; border-radius: 8px;"></video>
                                            <p>Incoming Call...</p>
                                            <audio id="incomingVideoRingingAudio" src="ringing.mp3" loop></audio>
                                            <div class="mt-3">
                                                <i class="fas fa-phone-slash text-danger" id="rejectIncomingVideoCall"
                                                    style="cursor: pointer; font-size: 24px;" title="Reject Call"></i>
                                                <i class="fas fa-phone text-success" id="acceptIncomingVideoCall"
                                                    style="cursor: pointer; font-size: 24px;" title="Accept Call"></i>
                                                <i class="fas fa-microphone-slash text-secondary" id="muteIncomingVideo"
                                                    style="cursor: pointer; font-size: 24px;" title="Mute Video"></i>
                                                <i class="fas fa-video-slash text-secondary" id="turnOffIncomingCamera"
                                                    style="cursor: pointer; font-size: 24px;" title="Turn Off Camera"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <div class="modal fade" id="emojiModal" tabindex="-1" aria-labelledby="emojiModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="emojiModalLabel">Select an Emoji</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div id="emojiPicker"></div>
                                            <div class="d-flex text-center mt-3">
                                                <div id="prevPage" class=" mx-2">
                                                    <i class="fa fa-chevron-left " aria-hidden="true"></i>
                                                </div>
                                                <span id="pageInfo"></span>
                                                <div id="nextPage" class=" mx-2">
                                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary m-2 mb-3" id="voiceBtn"
                                data-bs-toggle="modal" data-bs-target="#voiceModal">
                                <i class="fas fa-microphone"></i> <!-- Voice icon -->
                            </button>
                            <!-- Modal Structure -->
                            <div class="modal fade" id="voiceModal" tabindex="-1" aria-labelledby="voiceModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="voiceModalLabel">Record Voice Message</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Recording Controls -->
                                            <div id="startRecordBtn">
                                                <i class="fas fa-play mx-2"></i>
                                            </div>
                                            <div id="stopRecordBtn" disabled>
                                                <i class="fas fa-stop mx-2"></i>
                                            </div>

                                            <!-- Indicator when recording is active -->
                                            <div class="recording-indicator text-center mt-3" id="recordingIndicator">
                                                <!-- SVG Animated Recording Circle -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    fill="red" class="bi bi-record-circle-fill" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="6" fill="red" />
                                                </svg>
                                                <span> Recording...</span>
                                            </div>
                                            <audio class="voice-message mt-3 w-100" id="audioPlayback" controls></audio>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="sendMessageBtn">Attach
                                                Voice Message
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary m-2 mb-3"> <i class="fa fa-paper-plane"
                                    aria-hidden="true"></i></button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script>
        function sendMessage(event) {
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
        }

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
    </script> --}}

    <script>
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
   
@endsection
