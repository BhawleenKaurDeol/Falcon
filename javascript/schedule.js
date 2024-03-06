
function addCourse() {
    var room = document.getElementById("room").value;
    var Code = document.getElementById("Code").value;
    var day = document.getElementById("day").value;
    var time = document.getElementById("time").value;
  
    var newRow = document.createElement("tr");
    newRow.innerHTML = `
      <td>${room}</td>
      <td>${Code}</td>
      <td>${day}</td>
      <td>${time}</td>
    `;
    
    document.getElementById("scheduleBody").appendChild(newRow);
  }

  