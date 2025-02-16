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