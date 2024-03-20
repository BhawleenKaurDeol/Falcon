
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('profileForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Collect form data
        const formData = {
            'student_id': document.querySelector('input[name="student_id"]').value,
            'emailid': document.querySelector('input[name="emailid"]').value,
            'password-field': document.querySelector('input[name="password-field"]').value,
            'password-field2': document.querySelector('input[name="password-field2"]').value
        };

        //  logData();
    });
});
let logged_user_id = 6;
async function logData() {
    const response = await fetch("https://inteligencia.ec/falcon/api.php?id=" + logged_user_id + "&t=users-Id&token=XXX");
    const data = await response.json();
    console.log(data);
    document.querySelector('#profile_picture').src = data[0].picture;
    document.querySelector('input[name="student_id"]').value = data[0].student_id;
    document.querySelector('input[name="emailid"]').value = data[0].email;
    document.querySelector('input[name="given_name"]').value = data[0].given_name;
    document.querySelector('input[name="last_name"]').value = data[0].last_name;
    document.querySelector('input[name="gender"]').value = data[0].gender;
    document.querySelector('input[name="phone"]').value = data[0].phone_number;
}
logData();
















