function error_message(error_msg){
    Swal.fire({
        title: 'Error!',
        text: error_msg,
        icon: 'error',
        showCloseButton: true,
        denyButtonText: `OK`
      });   
  }

const inputs = document.querySelectorAll("input");
const form = document.getElementById("SignUpForm");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm-password");
const showPassword = document.getElementById("show-password");
const iconPassword = document.querySelector("#show-password i");
const matchPassword = document.getElementById("match");
const submit = document.getElementById("CreateBtn");
const student = document.getElementById("student_id");
const given_name = document.getElementById("given_name");
const requirement_student_id=document.getElementById('requirement_student_id');
const student_length=document.getElementById('student_length');
const requirements=document.getElementById('requirements');
const studentExists=document.getElementById('student_id_exists');

inputs.forEach((input) => {
  input.addEventListener("blur", (event) => {
    if (event.target.value) {
      input.classList.add("is-valid");
    } else {
      input.classList.remove("is-valid");
    }
  });
});

showPassword.addEventListener("click", (event) => {
  if (password.type == "password") {
    password.type = "text";
    confirmPassword.type = "text";
    iconPassword.classList.remove("fa-eye");
    iconPassword.classList.add("fa-eye-slash");
    showPassword.setAttribute("aria-label", "hide password");
    showPassword.setAttribute("aria-checked", "true");
  } else {
    password.type = "password";
    confirmPassword.type = "password";
    iconPassword.classList.add("fa-eye");
    iconPassword.classList.remove("fa-eye-slash");
    showPassword.setAttribute("aria-label", "show password");
    showPassword.setAttribute("aria-checked", "false");
  }
});

const updateRequirement = (id, valid) => {
  const requirement = document.getElementById(id);

  if (valid) {
    requirement.classList.add("valid");
  } else {
    requirement.classList.remove("valid");
  }
};

password.addEventListener("input", (event) => {
  const value = event.target.value;
  password_check(value)
});
function password_check(value){
    
    requirements.classList.add('show_signup');
    updateRequirement("length", value.length >= 8);
    updateRequirement("lowercase", /[a-z]/.test(value));
    updateRequirement("uppercase", /[A-Z]/.test(value));
    updateRequirement("number", /\d/.test(value));
    updateRequirement("characters", /[#.?!@$%^&*-]/.test(value));
    if(value==''){
      requirements.classList.remove('show_signup');
    }
}

confirmPassword.addEventListener("blur", (event) => {
  const value = event.target.value;

  if (value.length && value != password.value) {
    matchPassword.classList.remove("hidden");
  } else {
    matchPassword.classList.add("hidden");
  }
});

confirmPassword.addEventListener("focus", (event) => {
  matchPassword.classList.add("hidden");
});

const handleFormValidation = () => {
  const value = password.value;
  const confirmValue = confirmPassword.value;
  


  if (
   
    value.length >= 8 &&
    /[a-z]/.test(value) &&
    /[A-Z]/.test(value) &&
    /\d/.test(value) &&
    /[#.?!@$%^&*-]/.test(value) &&
    value == confirmValue
  ) {
    submit.removeAttribute("disabled");
    return true;
  }

  submit.setAttribute("disabled", true);
  return false;
};

form.addEventListener("change", () => {
  handleFormValidation();
});

form.addEventListener("submit",  async event => {
  event.preventDefault();
  const validForm = handleFormValidation();

  if (!validForm) {
    return false;
  }

  const data = new FormData(form);
    
  //console.log(Array.from(data));
  
  try {
    const res = await fetch(
        "api.php?id=" + logged_user_id + "&t=users-Id&token=XXX",
      {
        method: 'POST',
        body: data,
      },
    );
  
    const resData = await res.json();
  
   // console.log(resData);
  
    if(resData.result=='true'){
        Swal.fire({
            title: "Success!",
            text: "Your account has been update, you can continue using Falcon APP.",
            icon: "success"
          }).then(function (result) {
            if (true) {
              window.location = "index.php";
            
        }
          });
       }else{
        error_message('There was an error!')
     //      alert('There was an error');
       }
  } catch (err) {
    console.log(err.message);
  }
 

});



const MainForm =  document.getElementById("SignUpForm");
MainForm.setAttribute("autocomplete", "one-time-code");
MainForm.addEventListener(
  "focus",
  (event) => {
const demoClasses = document.querySelectorAll("input");
demoClasses.forEach(element => {
  element.setAttribute("autocomplete", "one-time-code");
});
//console.log(demoClasses);

  },
  true,
);
function limit(element)
{
    var max_chars = 9;
         
    if(element.value.length > max_chars) {
        element.value = element.value.substr(0, max_chars);
    }
}
given_name.focus();
handleFormValidation();
password_check(password.value)