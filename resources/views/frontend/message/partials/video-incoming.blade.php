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