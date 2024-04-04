

function error_message(error_msg){
  Swal.fire({
      title: 'Error!',
      text: error_msg,
      icon: 'error',
      showCloseButton: true,
      denyButtonText: `OK`
    });   
}


const form = document.getElementById('form_login');

form.addEventListener('submit', async event => {
event.preventDefault();

const data = new FormData(form);

console.log(Array.from(data));

try {
  const res = await fetch(
    'login_process.php',
    {
      method: 'POST',
      body: data,
    },
  );

  const resData = await res.json();

  console.log(resData);

  if(resData.login=='true'){
         window.location.replace("index.php");
     }else{
         error_message('Your login details are incorrect!')
     }
} catch (err) {
  console.log(err.message);
}
});

document.querySelector('#btn_signup').addEventListener('click',function(e){
e.preventDefault();
window.location.replace("signup.php");
})