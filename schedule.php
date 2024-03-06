<?php
ini_set('max_execution_time', '0');
header('Content-Type: text/html; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <link rel="stylesheet" href="css/schedule.css">
    <script src="javascript/schedule.js" defer></script>
    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="falcon-body">
    <?php 
    include "header.php";
    ?>
    <main id="main_content">
    <h1>Schedule</h1>

<div class="page" id="profile" >
    <div id="card">

        <form id="courseForm">
            <label for="room">Select Room:</label>
            <select id="room" name="room">
              <option value="B018">B018</option>
              <option value="B014">B014</option>
              <option value="B016">B016</option>
            </select><br><br>
          
            <label for="Code">Select Course Code:</label>
            <select id="Code" name="Code">
              <option value="course1">WMDD 4835</option>
              <option value="course2">WMDD 4840</option>
              <option value="course3">WMDD 4885</option>
            </select><br><br>
          
            <label for="day">Select Day:</label>
            <select id="day" name="day">
              <option value="monday">Monday</option>
              <option value="tuesday">Tuesday</option>
              <option value="wednesday">Wednesday</option>
              <option value="thursday">Thursday</option>
              <option value="friday">Friday</option>
              <option value="saturday">Saturday</option>
            </select><br><br>
          
            <label for="time">Select Time:</label>
            <select id="time" name="time">
              <option value="9am">9:00 AM</option>
              <option value="10am">10:00 AM</option>
              <option value="11am">11:00 AM</option>
              <!-- Add more options as needed -->
            </select><br><br>
          
            <button type="button" onclick="addCourse()">Add Course</button>
          </form>
          
          <h2>My Schedule</h2>
          
          <table id="scheduleTable">
            <thead>
              <tr>
                <th>Room</th>
                <th>Code</th>
                <th>Day</th>
                <th>Time</th>
              </tr>
            </thead>
            <tbody id="scheduleBody">
            
            </tbody>
          </table>

          <button type="button" onclick="addCourse()">Add Course</button>

    </div>
</div>


    </main>
<?php
include "footer.php";
?>

   
</body>
</html>