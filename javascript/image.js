

document.addEventListener('DOMContentLoaded', function () {
    var cropper;
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    var startButton = document.getElementById('startbutton');
    var imageElement = document.getElementById('image-to-crop');
    var fileInput = document.getElementById('file-input');
    var cropButton = document.getElementById('btn-crop');
    var output = document.getElementById('output');

    // Function to initialize Cropper
    function initializeCropper() {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(imageElement, {
            aspectRatio: 3 / 4,
        });
    }

    // Initialize Webcam
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                 video.srcObject = stream;
                 video.play();
            })
            .catch(function (err) {
                console.log("Something went wrong!", err);
            });
    }

    // Take a picture from webcam
    startButton.addEventListener('click', function () {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        var imageDataUrl = canvas.toDataURL('image/png');
        
        imageElement.src = imageDataUrl;
        document.querySelector('.img-container').style.display = 'block';
        initializeCropper();
    });

    // Handle file input change
    fileInput.addEventListener('change', function (event) {
        var files = event.target.files;
        var file;
        if (files && files.length > 0) {
            file = files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                imageElement.src = e.target.result;
                document.querySelector('.img-container').style.display = 'block';
                initializeCropper();
            };
            reader.readAsDataURL(file);
        }
    });

    // Crop the image
    cropButton.addEventListener('click', function () {
        if (cropper) {
            var croppedImage = cropper.getCroppedCanvas().toDataURL('image/png');
            output.src = croppedImage;
            document.querySelector('.cropped-img').style.display = 'block';
        }
    });
});

