<div class="modal fade" id="outgoingVideoCallModal" tabindex="-1" aria-labelledby="outgoingVideoCallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outgoingVideoCallModalLabel">Outgoing Video Call
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
