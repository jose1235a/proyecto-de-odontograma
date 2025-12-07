<script>
$(document).ready(function() {
    // File input custom label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || '{{ __("global.select_file") }}');
    });

    // Camera functionality
    let videoStream = null;

    $('#take-photo-btn').on('click', function() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    videoStream = stream;
                    showCameraModal();
                })
                .catch(function(error) {
                    console.error('Error accessing camera:', error);
                    alert('{{ __("global.camera_access_denied") }}');
                });
        } else {
            alert('{{ __("global.camera_not_supported") }}');
        }
    });

    function showCameraModal() {
        // Create modal for camera
        const modalHtml = `
            <div class="modal fade" id="cameraModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('dental_management.patients.take_photo') }}</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <video id="camera-video" autoplay style="width: 100%; max-width: 500px;"></video>
                            <canvas id="camera-canvas" style="display: none;"></canvas>
                            <br><br>
                            <button type="button" class="btn btn-success" id="capture-btn">
                                <i class="fas fa-camera"></i> {{ __('global.capture') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('body').append(modalHtml);
        $('#cameraModal').modal('show');

        const video = document.getElementById('camera-video');
        video.srcObject = videoStream;

        $('#capture-btn').on('click', function() {
            capturePhoto();
        });

        $('#cameraModal').on('hidden.bs.modal', function() {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
            }
            $('#cameraModal').remove();
        });
    }

    function capturePhoto() {
        const video = document.getElementById('camera-video');
        const canvas = document.getElementById('camera-canvas');
        const context = canvas.getContext('2d');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/jpeg', 0.8);
        $('#photo-data').val(imageData);
        $('#photo-preview-img').attr('src', imageData);
        $('#photo-preview').show();

        // Close camera modal
        $('#cameraModal').modal('hide');

        // Clear file input if photo was taken
        $('#image').val('');
        $('.custom-file-label').html('{{ __("global.select_file") }}');
    }

    // Form validation
    $('#form-save').on('submit', function(e) {
        const hasImage = $('#image').val() !== '';
        const hasPhoto = $('#photo-data').val() !== '';

        if (!hasImage && !hasPhoto) {
            e.preventDefault();
            alert('{{ __("dental_management.patient_images.validation.image_required") }}');
            return false;
        }

        // Show loading
        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> {{ __("global.saving") }}');
    });
});
</script>