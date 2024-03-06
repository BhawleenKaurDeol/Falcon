
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    var modal = document.getElementById("myModal");

    // When the page loads, open the modal 
    modal.style.display = "block";

    

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Button event listeners
    document.getElementById("cameraBtn").addEventListener("click", function() {
        console.log("Camera button clicked");
        // Implement camera functionality here
        modal.style.display = "none";
        startButton.style.display = 'block';
    });

    document.getElementById("uploadBtn").addEventListener("click", function() {
        console.log("Upload button clicked");
        // Trigger file input here or handle upload

        document.getElementById('file-input').style.display = 'block';
         modal.style.display = "none";
        startButton.style.display = 'none';
    });
});


// document.addEventListener('DOMContentLoaded', function () {
    var cropper;
    var canvas = document.getElementById('canvas');
    var video = document.getElementById('video');
    var startButton = document.getElementById('startbutton');
    var imageElement = document.getElementById('image-to-crop');
    // var fileInput = document.getElementById('file-input');
    var cropButton = document.getElementById('btn-crop');
    var output = document.getElementById('output');
    var cameraBtn = document.getElementById('cameraBtn'); // Ensure this ID matches your Camera button
    document.getElementById('btn-crop').style.display = 'none';
    var saveButtons = document.querySelector('.save-cancel');
    saveButtons.style.display = 'none';

    cameraBtn.addEventListener('click', function () {
        initializeWebcam();
        // Hide the file-input button
        document.getElementById('file-input').style.display = 'none';
        // You can also add other UI adjustments as necessary, such as showing the video stream if it's not already visible
    });

    // Function to initialize Cropper
    function initializeCropper() {
        if (cropper) {
            cropper.destroy();
        }
        cropper = new Cropper(imageElement, {
            aspectRatio: 3 / 4,
        });
    }

    // Function to initialize Webcam
    function initializeWebcam() {
        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    video.srcObject = stream;
                    video.play();
                    // Show the video element and/or hide the modal here if needed
                })
                .catch(function (err) {
                    console.log("Something went wrong!", err);
                    // Properly handle the error here (e.g., show a message to the user)
                });
        }
    }

    // Event listener for the camera button in your modal
    cameraBtn.addEventListener('click', function () {
        initializeWebcam();
        // Close the modal if you have one, or perform other UI adjustments as necessary
    });

    // Take a picture from webcam
    startButton.addEventListener('click', function () {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        var imageDataUrl = canvas.toDataURL('image/png');
        
        imageElement.src = imageDataUrl;
        document.querySelector('.img-container').style.display = 'block';
        initializeCropper();

        document.getElementById('btn-crop').style.display = 'block'; 

        if (video.srcObject) {
            const tracks = video.srcObject.getTracks();
            tracks.forEach(track => track.stop());
        }
    
        // Hide the "Take photo" button
        startButton.style.display = 'none';

        video.style.display = 'none';
    });
    

    // Handle file input change
    // fileInput.addEventListener('change', function (event) {
    //     var files = event.target.files;
    //     if (files && files.length > 0) {
    //         var file = files[0];
    //         var reader = new FileReader();
    //         reader.onload = function (e) {
    //             imageElement.src = e.target.result;
    //             document.querySelector('.img-container').style.display = 'block';
    //             initializeCropper();
    //         };
    //         reader.readAsDataURL(file);
    //     }
    // });

    // Add event listener to the custom "Upload" button
document.getElementById("uploadBtn").addEventListener("click", function () {
    // Trigger click event on the hidden file input
    document.getElementById("file-input").click();
});

// Handle file input change
document.getElementById("file-input").addEventListener("change", function (event) {
    var files = event.target.files;
    if (files && files.length > 0) {
        var file = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            // Handle the file data or update UI as needed
            console.log("File selected:", file.name);

            imageElement.src = e.target.result;
            let ic = document.querySelector('.img-container')
            ic.style.display = 'block';
             ic.style.width = "640px";
             ic.style.height = "484px";
            initializeCropper();
            cropButton.style.display="block";

        };
        reader.readAsDataURL(file);
    }
});

    cropButton.addEventListener('click', function () {
        if (cropper) {
            var croppedImage = cropper.getCroppedCanvas().toDataURL('image/png');
            output.src = croppedImage;
            let ci= document.querySelector('.cropped-img')
            ci.style.display = 'block';
        
        }
    });

    cropButton.addEventListener('click', function () {
        if (cropper) {
            // Disable Cropper and hide the drag box
           let ic = document.querySelector('.img-container')
            ic.style.display = "none";
            cropButton.style.display="none";
        
            saveButtons.style.display = 'grid';
    
            // Get the cropped image and display it
            var croppedImage = cropper.getCroppedCanvas().toDataURL('image/png');
            output.src = croppedImage;
            document.querySelector('.cropped-img').style.display = 'block';

            
        }
        document.getElementById('save').addEventListener('click', function() {
            var croppedImage = cropper.getCroppedCanvas().toDataURL('image/png');
        
            fetch("https://inteligencia.ec/falcon/api.php?id="+logged_user_id+"&t=users-Id&token=XXX", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ image: croppedImage }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                
            })
            .catch((error) => {
                console.error('Error:', error);
                
            });

    });
    });
