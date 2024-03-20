  
async function logData() {
  const response = await fetch("api.php?id=" + logged_user_id + "&t=users-Id&token=XXX");
    const data = await response.json();
  console.log(data);
  document.querySelector('#profile_picture').src = data[0].picture;
  document.querySelector('#student_id').value = data[0].student_id;
  document.querySelector('#email').value = data[0].email;
  document.querySelector('#given_name').value = data[0].given_name;
  document.querySelector('#last_name').value = data[0].last_name;
  document.querySelector('#gender').value = data[0].gender;
  document.querySelector('#phone_number').value = data[0].phone_number;
  document.querySelector('#date_expire').value = data[0].date_expire;
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