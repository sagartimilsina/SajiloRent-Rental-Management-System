    <style>
        
    </style>

    <div class="container-fluid p-0 card">
        <div class="row g-0">
            <!-- Chat List -->
            <div class="col-md-4 col-lg-3 chat-list">
                <div class="list-group list-group-flush" id="chatList"></div>
            </div>

            <!-- Chat Area -->
            <div class="col-md-8 col-lg-9">
                <div class="chat-container">
                    <!-- Chat Header -->
                    <div class="p-3 border-bottom">
                        <h5 id="currentChatUser">Select a chat</h5>
                        <small id="currentChatInfo" class="text-muted"></small>
                    </div>

                    <!-- Messages Area -->
                    <div class="chat-messages" id="messageContainer"></div>

                    <!-- Chat Input -->
                    <div class="voice-recording" id="voiceRecording">
                        Recording... <span id="recordingTime">0:00</span>
                        <button class="btn btn-sm btn-light ms-2" id="stopRecording">
                            <i class="fas fa-stop"></i>
                        </button>
                    </div>

                    <!-- Chat Input -->
                    <div class="chat-input-container">
                        <form id="chatForm" class="d-flex gap-2">
                            <input type="file" id="fileInput" class="d-none"
                                accept="image/*,video/*,audio/*,.pdf,.doc,.docx">
                            <label for="fileInput" class="btn btn-outline-secondary">
                                <i class="fas fa-paperclip"></i>
                            </label>
                            <input type="text" id="messageInput" class="form-control"
                                placeholder="Type your message...">
                            <button type="button" class="btn btn-outline-secondary" id="voiceBtn">
                                <i class="fas fa-microphone"></i>
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        class ChatManager {
            constructor() {
                this.currentUserId = null;
                this.messageContainer = $('#messageContainer');
                this.chatForm = $('#chatForm');
                this.messageInput = $('#messageInput');
                this.chatList = $('#chatList');
                this.mediaRecorder = null;
                this.recordedChunks = [];
                this.isRecording = false;
                this.recordingTimer = null;

                this.initializeEventListeners();
                this.loadChatList();
                this.setupVoiceRecording();
            }

            initializeEventListeners() {
                this.chatForm.on('submit', (e) => this.handleMessageSubmit(e));
                this.chatList.on('click', '.user-item', (e) => this.handleUserSelect(e));

                // File input handling
                $('#fileInput').on('change', (e) => this.handleFileUpload(e));

                $('#voiceBtn').on('click', () => this.toggleVoiceRecording());
                $('#stopRecording').on('click', () => this.stopVoiceRecording());
                this.messageContainer.on('click', '.delete-message', (e) => this.deleteMessage(e));
            }

            loadChatList() {
                // Sample chat list data - replace with your actual data source
                const chatData = [{
                        id: 1,
                        name: 'John Doe',
                        company: 'Company 1',
                        product: 'Product 1',
                        lastMessage: 'Hey, are you available?'
                    },
                    {
                        id: 2,
                        name: 'Jane Smith',
                        company: 'Company 2',
                        product: 'Product 2',
                        lastMessage: 'Meeting at 10 AM'
                    }
                ];

                this.chatList.html(chatData.map(chat => this.createChatListItem(chat)).join(''));
            }

            createChatListItem(chat) {
                return `
                    <div class="user-item list-group-item list-group-item-action" data-user-id="${chat.id}">
                        <div class="d-flex align-items-center">
                            <img src="frontend/assets/images/profile.avif" class="rounded-circle me-3 img-fluid " style="width:40px; height:40px;" alt="${chat.name}">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">${chat.name}</h6>
                                <p class="mb-1 small text-muted">${chat.company}</p>
                                <p class="mb-1 small text-muted">Product: ${chat.product}</p>
                             
                            </div>
                        </div>
                    </div>
                `;
            }

            handleUserSelect(e) {
                const userId = $(e.currentTarget).data('user-id');
                this.currentUserId = userId;

                $('.user-item').removeClass('active');
                $(e.currentTarget).addClass('active');

                this.loadChatHistory(userId);
                this.updateChatHeader(e.currentTarget);
            }

            loadChatHistory(userId) {
                // Replace with your actual chat history loading logic
                this.messageContainer.empty();
                // Simulate loading messages
                this.addMessage('Hello!', false, '10:00 AM');
                this.addMessage('Hi there!', true, '10:01 AM');
            }

            handleMessageSubmit(e) {
                e.preventDefault();
                const message = this.messageInput.val().trim();

                if (message && this.currentUserId) {
                    this.sendMessage(message);
                    this.messageInput.val('');
                }
            }

            sendMessage(message) {
                // Add message to UI immediately
                this.addMessage(message, true, new Date().toLocaleTimeString());

                // Send message to server (replace with your actual API call)
                // $.post('/api/messages', {
                //     userId: this.currentUserId,
                //     message: message
                // });
            }
            setupVoiceRecording() {
                navigator.mediaDevices.getUserMedia({
                        audio: true
                    })
                    .then(stream => {
                        this.mediaRecorder = new MediaRecorder(stream);
                        this.mediaRecorder.ondataavailable = (e) => {
                            if (e.data.size > 0) {
                                this.recordedChunks.push(e.data);
                            }
                        };
                        this.mediaRecorder.onstop = () => this.handleVoiceMessage();
                    })
                    .catch(error => console.error('Error accessing microphone:', error));
            }

            toggleVoiceRecording() {
                if (!this.isRecording) {
                    this.startVoiceRecording();
                } else {
                    this.stopVoiceRecording();
                }
            }

            startVoiceRecording() {
                this.isRecording = true;
                this.recordedChunks = [];
                this.mediaRecorder.start();
                $('#voiceRecording').show();
                this.startRecordingTimer();
            }

            stopVoiceRecording() {
                if (this.isRecording) {
                    this.isRecording = false;
                    this.mediaRecorder.stop();
                    $('#voiceRecording').hide();
                    clearInterval(this.recordingTimer);
                }
            }

            startRecordingTimer() {
                let seconds = 0;
                this.recordingTimer = setInterval(() => {
                    seconds++;
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    $('#recordingTime').text(`${minutes}:${remainingSeconds.toString().padStart(2, '0')}`);
                }, 1000);
            }

            handleVoiceMessage() {
                const blob = new Blob(this.recordedChunks, {
                    type: 'audio/webm'
                });
                const url = URL.createObjectURL(blob);
                const audioElement = `
                    <div class="voice-message">
                        <audio controls src="${url}"></audio>
                        <span class="timestamp">${new Date().toLocaleTimeString()}</span>
                    </div>
                `;
                this.addMessage(audioElement, true, new Date().toLocaleTimeString(), 'voice');
            }
            deleteMessage(e) {
                $(e.target).closest('.message-bubble').remove();
            }


            addMessage(message, isSent, timestamp) {
                const messageHtml = `
                    <div class="message-bubble ${isSent ? 'message-sent' : 'message-received'}">
                        <div class="message-text">${message}</div>
                        <div class="timestamp">${timestamp}</div>
                    </div>
                `;

                this.messageContainer.append(messageHtml);
                this.scrollToBottom();
            }

            scrollToBottom() {
                this.messageContainer.scrollTop(this.messageContainer[0].scrollHeight);
            }

            updateChatHeader(userElement) {
                const userName = $(userElement).find('h6').text();
                const company = $(userElement).find('p:first').text();

                $('#currentChatUser').text(userName);
                $('#currentChatInfo').text(company);
            }

            handleFileUpload(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        let preview = '';
                        if (file.type.startsWith('image/')) {
                            preview = `<img src="${event.target.result}" class="attachment-preview">`;
                        } else {
                            preview = `<div class="attachment-preview">
                                        <i class="fas fa-file"></i> ${file.name}
                                      </div>`;
                        }
                        this.addMessage(preview, true, new Date().toLocaleTimeString(), 'file');
                    };
                    reader.readAsDataURL(file);
                }
            }


        }

        // Initialize chat manager when document is ready
        $(document).ready(() => {
            const chatManager = new ChatManager();
        });
    </script>
