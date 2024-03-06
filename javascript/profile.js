console.log("HII");

// fetching the image tag from both the files
let profileImage = "";
let setProfileImage = document.getElementById("profile_image");




// This function is called when the user clicks the set profile image button in the image.php file 

function SetProfileImage(){

    profileImage = document.getElementById("output").src;
    console.log(profileImage);
    window.location.replace("profile.php");
// setProfileImage.src= `"${profileImage}"`+".jpeg"
setProfileImage.src= profileImage.src;


}


function ValidateEmail(input) {

    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
  
    if (input.value.match(validRegex)) {
  
      alert("Valid email address!");
  
  
      return true;
  
    } else {
  
      alert("Invalid email address!");
    
      return false;
  
    }
  
  }
  
  const form_profile = document.getElementById('profileForm');

  form_profile.addEventListener('submit', async event => {
  event.preventDefault();
  
  const data = new FormData(form_profile);
  
  alert("Hii");
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
  
    
  } catch (err) {
    console.log(err.message);
  }
  });