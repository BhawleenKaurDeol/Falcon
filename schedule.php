<?php
ini_set("max_execution_time", "0");
header("Content-Type: text/html; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
include "includes/application_top.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Falcon APP - PROFILE</title>
    <script src="https://kit.fontawesome.com/6155c8fec8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/schedule.css">
    <link rel="icon" type="image/png" href="images/falcon-icon.png">
    <script src="javascript/schedule.js" defer></script>
    
</head>
<body class="falcon-body ">
    <?php include "header.php"; ?>
    <main id="main_content" class="schedule">

  
        <h1 id="formTitle">Schedule</h1>
        

<div class="page" id="profile" >
        <div id="card">

            <form id="courseForm" class="edit-form edit-form-hidden">
                <label for="room">Select Room:</label>
             
                <div>
    <datalist id="room-suggestions">
    </datalist>
    <input  id="room" name="id_room" autoComplete="on" list="room-suggestions"/> 
</div>
                <br><br>
              
                <label for="Code">Select Course Code:</label>

                <div>
    <datalist id="Code-suggestions">
    </datalist>
    <input  id="Code" name="id_course" autoComplete="on" list="Code-suggestions"/> 
</div>
               
            <br><br>
              
       

        <label for="term">Term:</label>
        <select id="term" name="term">
          <option value="Spring">Spring 2024</option>
          <option value="Fall">Fall 2024</option>
          <option value="Summer">Summer 2024</option>
        </select><br><br>

        <label for="day">Day:</label>
        <select id="day" name="day">
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
          <option value="Saturday">Saturday</option>
        </select><br><br>
              
        <label for="startTime">Start Time:</label>
        <input type="time" id="startTime" name="start_hour_schedule"><br><br>

        <label for="endTime">End Time:</label>
        <input type="time" id="endTime" name="end_hour_schedule"><br><br>


              <!--needed for the submission to update the database, action to be 0 when fresh the database  userId file display this info at the button--> 

              <!-- https://www.inteligencia.ec/falcon/api.php?id=5&t=schedule-userId&token=XXX -->

              <!-- <input type="hidden" value="1" name="action"/> -->
        <input type="hidden" value="0" name="action"/>
        <input type="hidden" value="1" name="id_schedule"/>

                <button type="button" onclick="addCourse()">Add Course</button>

                <button type="button" 
                id="view-schedule-button"
                onclick="viewSchedule()">View Schedule</button>
              </form>
   


              
              <!-- <div id="table-container" class="hidden"> -->

              <div id="table-container">
              <!-- <h2>My Schedule</h2> -->
              
              <table id="scheduleTable">
                <thead>
                  <tr>
                    <th>Select</th>
                    <th>Room</th>
                    <th>Code</th>
                    <th>Term</th>
                    <th>Day</th>
                    <th colspan=2 >Time</th>
                  </tr>
                </thead>
                <tbody id="scheduleBody">
                
                </tbody>
              </table>

              <button type="button" onclick="showForm()">Add New Course</button>

              <button id="delete-course" type="button" onclick="deleteCourse()">Delete Course</button>

              <button id="edit-course"  type="button" onclick="editCourse()">Edit Course</button>
              </div>

            

        </div>
    </div>
   


    </main>

<?php include "footer.php"; ?>
</body>
</html>