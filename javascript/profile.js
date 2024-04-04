  
async function logData() {
  const response = await fetch("api.php?id=" + logged_user_id + "&t=users-Id&token=XXX");
    const data = await response.json();
  console.log(data);
  let new_pic="images/placeholder-face.jpg";
  data.forEach(user => {
    if(user.picture!=null){
      new_pic=user.picture;
    }
    document.querySelector('#profile_picture').src = new_pic;
  document.querySelector('#student_id').value = user.student_id;
  document.querySelector('#email').value = user.email;
  document.querySelector('#given_name').value = user.given_name;
  document.querySelector('#last_name').value = user.last_name;
  document.querySelector('#gender').value = user.gender;
  document.querySelector('#phone_number').value = user.phone_number;
  document.querySelector('#date_expire').value = user.date_expire;
  });
  
}
logData();


const form = document.getElementById('profileForm');
  
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