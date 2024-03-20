function start_popup_msg() {
    Swal.fire({
        title: "What do you want to do?",
        text: "To update your profile picture you can either use your camera to take a new picture or upload a file.",
        imageUrl: "images/picture_cam.png",
        imageWidth: 200,
        imageHeight: 200,
        imageAlt: "Take a picture or upload a file",
        confirmButtonText: `<i class="fa-solid fa-camera"></i> &nbsp;Take a picture`,
        confirmButtonAriaLabel: "Camera, Take a picture!",
        showDenyButton: true,
        denyButtonText: `<i class="fa-solid fa-upload"></i> &nbsp;Upload an image`,
        showCloseButton: true,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            //          Swal.fire("Saved!", "", "success");
            document.getElementById('image_camera').classList.remove('hide');

            initializeWebcam();
        } else if (result.isDenied) {
            document.getElementById('file-input').classList.remove('hide');
            document.getElementById('image_cropper').classList.remove('hide');
            file_trigger();
        } else {
            gotoProfile();
        }
    });
}
// function popup_file() {
//   await  Swal.fire({
//         title: "Select image",
//         input: "file",
//         inputAttributes: {
//             "accept": "image/*",
//             "aria-label": "Upload your profile picture"
//         }
//     });
//       if (file) {
//         const reader = new FileReader();
//         reader.onload = (event) => {
//             var files = event.target.files;
//             if (files && files.length > 0) {
//                 var file = files[0];
//                 var reader = new FileReader();
//                 reader.onload = function (e) {
//                     imageElement.src = e.target.result;
//                     document.querySelector('.img-container').style.display = 'block';
//                     initializeCropper();
//                     document.getElementById('image_cropper').classList.remove('hide');
//                 };
//              //   reader.readAsDataURL(file);
//             }

//         };
//         reader.readAsDataURL(file);
//       }

    //  var files = event.target.files;
 
     
//}
function gotoProfile() {
    window.location.replace("profile.php");
}
start_popup_msg();
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

var saveButtons = document.querySelector('.save-cancel');



// Function to initialize Cropper
function initializeCropper() {
    if (cropper) {
        cropper.destroy();
    }
    cropper = new Cropper(imageElement, {
      
        dragMode: 'move',
        data: {
            width: 446,
            height: 500,
           // top:
          },
          minContainerWidth:640,
          minContainerHeight:480,
         aspectRatio: 446 / 500,
        // autoCropArea: 0.80,
  
     
       // aspectRatio: 16 / 9,
      //  autoCropArea: ,
        restore: false,
        responsive:true,
        guides: true,
        center: true,
        highlight: true,
        cropBoxMovable: true,
        cropBoxResizable: false,
        toggleDragModeOnDblclick: false,
        ready: function () {
            var cropper = this.cropper;
            var containerData = cropper.getContainerData();
            var cropBoxData = cropper.getCropBoxData();
            var aspectRatio = cropBoxData.width / cropBoxData.height;
          //  var newCropBoxWidth;

              cropper.setCropBoxData({
                left: (containerData.width - 1000) / 2,
                width: 1000,
                height:1000,
              });
            }
          
        

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


// Take a picture from webcam
startButton.addEventListener('click', function () {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    var imageDataUrl = canvas.toDataURL('image/png');


    document.getElementById('image_camera').classList.add('hide');
    document.getElementById('image_cropper').classList.remove('hide');


    imageElement.src = imageDataUrl;

    initializeCropper();



    if (video.srcObject) {
        const tracks = video.srcObject.getTracks();
        tracks.forEach(track => track.stop());
    }

    // Hide the "Take photo" button

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


// Handle file input change
function file_trigger() {
    let input = document.createElement('input');
    input.type = 'file';
    input.onchange = _ => {
      // you can use this method to get file and perform respective operations
              let files =   Array.from(input.files);
              if (files && files.length > 0) {
                var file = files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    // Handle the file data or update UI as needed
                    console.log("File selected:", file.name);
        
                    imageElement.src = e.target.result;
                    let ic = document.querySelector('.img-container')
        
                     ic.style.width = "640px";
                     ic.style.height = "484px";
                    initializeCropper();
        
        
                };
                reader.readAsDataURL(file);
            }

              console.log(files);
          };
    input.click();
    
  }




cropButton.addEventListener('click', function () {
    if (cropper) {
        // Disable Cropper and hide the drag box
        let ic = document.querySelector('.img-container')





        // Get the cropped image and display it
        var croppedImage = cropper.getCroppedCanvas().toDataURL('image/png');
        output.src = croppedImage;
        document.getElementById('picture').value=croppedImage;


        document.getElementById('image_cropper').classList.add('hide');
        document.getElementById('image_result').classList.remove('hide');

    }
    


});

const form = document.getElementById('form_picture');
    
form.addEventListener('submit', async event => {
event.preventDefault();

const data = new FormData(form);

console.log(Array.from(data));

try {
  const res = await fetch(
    "api.php?id=" + logged_user_id + "&t=users-Id&token=XXX",
    {
      method: 'POST',
      body: data,
    },
  );

  const resData = await res.json();

  console.log(resData);

  if(resData.result=='true'){
         window.location.replace("profile.php");
        console.log('Success!!!');
     }else{
   //      alert('There was an error');
     }
} catch (err) {
  console.log(err.message);
}
});