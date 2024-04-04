const allRooms = [];
const allCourses = [];

// Change color of element selected
function removeClassFromClassElements(className, classToRemove) {
  var elements = document.getElementsByClassName(className);
  for (var i = 0; i < elements.length; i++) {
      elements[i].classList.remove(classToRemove);
  }
}

// Load data
async function logData() {
  logged_user_id=5;
  // Requst
  const response = await fetch("api.php?id=" + logged_user_id + "&t=schedule-userId&token=XXX");
  // Parse data to JSON
  const data = await response.json();
  // Loop each element from the request courses[]
  data.forEach(function(element){
    const {id_course, day_schedule, start_hour_schedule, term_schedule, end_hour_schedule, id_room, id_schedule} = element;
    // Create new row
    const newRow = createNewRow( id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule);
    // Create new cell
    const inputTd= createNewTd()
    // Append cell to row
    newRow.appendChild(inputTd);
    // Modify ROW with data object
    createRowElements(newRow, id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule)
    // ADD TO UI - Table
    assignNewRow(newRow)
  });
  
}
// Requests courses created by students
logData();

const createRowElements = (newRow, id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule) => {
  const roomElement = createRowElement(id_room);
  const CodeElement = createRowElement(id_course);
  const termElement = createRowElement(term_schedule);
  const dayElement = createRowElement(day_schedule);
  const startTimeElement = createRowElement(start_hour_schedule);
  const endTimeElement = createRowElement(end_hour_schedule);
  newRow.appendChild(roomElement)
  newRow.appendChild(CodeElement)
  newRow.appendChild(termElement)
  newRow.appendChild(dayElement)
  newRow.appendChild(startTimeElement)
  newRow.appendChild(endTimeElement)
}
const createRowElement = (value) => {
  const rowElement = document.createElement("td");
  rowElement.innerHTML = value;
  return rowElement;
}

async function addCourse() {
  alert("hello 2")
    const id_room = document.getElementById("room").value;
    const id_course = document.getElementById("Code").value;
    const term_schedule = document.getElementById("term").value;
    const day_schedule = document.getElementById("day").value;
    const start_hour_schedule = document.getElementById("startTime").value;
    const end_hour_schedule = document.getElementById("endTime").value;

    if (!id_room || !id_course|| !term_schedule|| !day_schedule|| !start_hour_schedule|| !end_hour_schedule){
      alert("Please enter your information")
      return
    }
    if(start_hour_schedule>end_hour_schedule){
      alert("Please enter a valid time")
      return
    }

    logged_user_id=5;
    const response = await fetch("api.php?id=" + logged_user_id + "&t=schedule-userId&token=XXX", {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule})
  });
    const course = await response.json();
    console.log(course, "course")
  
    const newRow = createNewRow(id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule);
    const inputTd= createNewTd();
    newRow.appendChild(inputTd);

    createRowElements(newRow, id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule)
    assignNewRow(newRow)

    alert("Your course has been sucessfully added!");

    // show the schedule form
  
    showTableContainer();
    updateButtonTextToCreate();
    showFormSchedule();
  }

  function resetFormValues() {
    const id_room = document.getElementById("room");
    id_room.value = "";
    const id_course = document.getElementById("Code");
    id_course.value = "";
    const term_schedule = document.getElementById("term");
    term_schedule.value = "";
    const day_schedule = document.getElementById("day");
    day_schedule.value = "";
    const start_hour_schedule = document.getElementById("startTime");
    start_hour_schedule.value = "";
    const end_hour_schedule = document.getElementById("endTime");
    end_hour_schedule.value = "";
    const idSchedule = document.getElementById("id_schedule");

    console.log(idSchedule)
    idSchedule.value = "";
  }

  function addNewCourse(){

    resetFormValues();
    updateButtonTextToCreate();
    hideTableContainer();
    showFormSchedule()
  }

  // TABLE CONTAINER FUNCTIONS DISPLAY

  function getTableContainer() {
   return document.getElementById("table-container");
  } 

  function showTableContainer(){
    const tableContainer = getTableContainer();
    tableContainer.classList.remove("hidden");
  }

  function hideTableContainer(){
    const tableContainer = getTableContainer();
    tableContainer.classList.add("hidden");
  }

  // END TABLE CONTAINER FUNCTIONS DISPLAY

  
  function showFormSchedule() {
    // const formTitle = document.getElementById("formTitle");
    const courseForm = document.getElementById("courseForm");
    // const tableContainer = document.getElementById("table-container");

    courseForm.classList.remove("edit-form-hidden");
  
    // formTitle.style.display = "block";
    // courseForm.style.display = "block";
    // tableContainer.style.display = "block";
  }

  // hide the schedule table and show again the schedule table



  async function addCourse() {
    // THIS IS BEING CALLED, NOT THE OTHER ONE
    const id_room = document.getElementById("room").value;
    const id_course = document.getElementById("Code").value;
    const term_schedule = document.getElementById("term").value;
    const day_schedule = document.getElementById("day").value;
    const start_hour_schedule = document.getElementById("startTime").value;
    const end_hour_schedule = document.getElementById("endTime").value;
  
    if (!id_room || !id_course || !term_schedule || !day_schedule || !start_hour_schedule || !end_hour_schedule) {
      alert("Please enter your information");
      return;
    }
    if (start_hour_schedule > end_hour_schedule) {
      alert("Please enter a valid time");
      return;
    }
  
    logged_user_id = 5;
    const response = await fetch("api.php?id=" + logged_user_id + "&t=schedule-userId&token=XXX", {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule })
    });
  
    const course = await response.json();
    console.log(course, "course")
  
    const newRow = createNewRow(id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule);
    const inputTd = createNewTd();
    newRow.appendChild(inputTd);
  
    createRowElements(newRow, id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule)
    assignNewRow(newRow)
  
    alert("Your course has been successfully added!");
  
    // Hide the schedule form table
    showTableContainer();
    hideScheduleForm();
  }
  
  function hideScheduleForm() {
    const formTitle = document.getElementById("formTitle");
    const courseForm = document.getElementById("courseForm");
    const tableContainer = document.getElementById("table-container");

    courseForm.classList.add("edit-form-hidden");
  
    // formTitle.style.display = "none";
    // courseForm.style.display = "none";
    // tableContainer.style.display = "block"; 
  }

    


    //  const formTitle=document.getElementById("formTitle");
    //  const courseForm=document.getElementById("courseForm");

    //  formTitle.classList.add("hidden");
    //  courseForm.classList.add("hidden");
    
    // const tableContainer=document.getElementById("table-container");
    //  tableContainer.classList.remove("hidden");

  // }

  const getScheduleBody = () => document.getElementById("scheduleBody");

  const setUpdateFormValues = (id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule) => {
    const room = document.getElementById("room");
    room.value = id_room;
    const course = document.getElementById("Code");
    const term = document.getElementById("term");
    const schedule = document.getElementById("day");
    const start = document.getElementById("startTime");
    const end = document.getElementById("endTime");
  }
  
  const createNewRow = (id_room, id_course, term_schedule, day_schedule, start_hour_schedule, end_hour_schedule) => {
    const newRow =document.createElement("tr");
    newRow.classList.add("course-row")
    newRow.addEventListener('click', () =>{
      removeClassFromClassElements("course-row","course-selected")
      localStorage.setItem("course-selected", JSON.stringify({
        id_room, id_course, term_schedule, day_schedule,  start_hour_schedule, end_hour_schedule
      }))
      setUpdateFormValues(id_room, id_course, term_schedule, day_schedule,  start_hour_schedule, end_hour_schedule)
      newRow.classList.add("course-selected")
    }) 
    return newRow
  };
  

  const assignNewRow = (newRow) => {
    const scheduleBody = getScheduleBody();
    scheduleBody.appendChild(newRow);
  }

  const createNewTd = (Code) => {
    const inputTd=document.createElement("td");
    const inputRadioButton=document.createElement("input");
    inputRadioButton.setAttribute("type", "radio");
    inputRadioButton.setAttribute("name", "course-radio-button");
    inputRadioButton.setAttribute("value",Code);
    inputTd.appendChild(inputRadioButton);
    return inputTd
  }


  // fetch

  // create variables to store my values
let newCourse = []
// let url = ""

const baseUrl = `https://inteligencia.ec/falcon/api.php`;
const roomsURL = baseUrl + `?t=room-all&token=XXX`;
const coursesURL = baseUrl + `?t=course-all&token=XXX`;


const RoomURL = "https://inteligencia.ec/falcon/api.php?t=room-all&token=XXX";
const CoursesURL = "https://inteligencia.ec/falcon/api.php?t=course-all&token=XXX";



// room 

const addInitialRooms = (rooms) =>{
console.log(rooms, "add initial rooms")
allRooms.push(...rooms)
console.log(allRooms,"allRooms allRooms allRooms")
console.log(rooms);

const elemetSelectRooms = document.getElementById("room-suggestions");

console.log(rooms, "rooms rooms")

rooms.forEach((room, id) => {

   // active status
  if(room.status_room=='active'){
 
    // code room + name room
  const option = document.createElement('option');
  option.textContent = room?.name_room;
  option.value = room?.name_room; 
   

  elemetSelectRooms.appendChild(option)
}})

}

// course 

const addInitialCourses = (courses) =>{
  allCourses.push(...courses)

  console.log(allCourses, "allCourses allCourses")
  const elemetSelectCourses = document.getElementById("Code-suggestions");
  
  courses.forEach((course) => {

    const courseName = course.name_course ? course.name_course : "Unnamed Course";


      // name course
    const option = document.createElement('option');
    option.value =   course.code_course;
    option.textContent = course.code_course + " - " + courseName;
     
  
    elemetSelectCourses.appendChild(option)
  })
  
  }

const getInitialData = async () => {
  try {

    // const responseRooms = await fetch(testRoomURL);
    const responseRooms = await fetch(roomsURL);
    // const responseCourse = await fetch(testCoursesURL);
    const responseCourse = await fetch(coursesURL);
  //   console.log(responseRooms, responseCourse )
    const roomsData = await responseRooms.json(); 
  //   console.log(roomsData, "roomsData") 
    const coursesData = await responseCourse.json();
  //   console.log(coursesData, "coursesData");

    addInitialRooms(roomsData)
    addInitialCourses(coursesData)
  } catch (error) {
    console.log(error)
  }
}

(async () => {
 await getInitialData()
})()

// delate button

const btnDelete = document.querySelector('.delete-course');



function deleteCourse() {
  var element = document.querySelector
  (".course-selected");
  if (element) {

    if (window.confirm("Do you really want to remove this course?")) {
      element.parentNode.removeChild(element);
    }
      
  } else {
      alert("You need to select an element first");
  }
}

// edit button

const btnEdit = document.querySelector('.edit-course');
  
function editCourse() {
  var element = document.querySelector
  (".course-selected");

  const courseSelected=localStorage.getItem("course-selected")

  if (element && courseSelected) {

    if (window.confirm("Do you really want to edit this course?")) {
    // Get selected row to edit and parse it from string to object
     const parsedCourseSelected=JSON.parse(courseSelected);
    //  Remove class from elements - color red selected
     removeClassFromClassElements
     ("edit-form", "edit-form-hidden")
    //  ROOM ELEMENT AND SET DATA
     const room = document.getElementById("room");
    //  Find room with id_room from stored row - localstorage.setItem
     const findRoom = allRooms.find(room => room.id_room == parsedCourseSelected.id_room)
     room.value= findRoom.name_room;
      //  COURSE ELEMENT AND SET DATA
     const Code = document.getElementById("Code");
     const findCourse = allCourses.find(course => course.id_course == parsedCourseSelected.id_course)
     Code.value=findCourse.name_course;
      //  TERM ELEMENT AND SET DATA
     const day = document.getElementById("day");
     day.value=parsedCourseSelected.day_schedule;
     const term_schedule = document.getElementById("term");
     term_schedule.value=parsedCourseSelected.term_schedule;
     //  START TIME ELEMENT AND SET DATA
     const startTime = document.getElementById("startTime");
    //  Cut value time from 09:30:34... to only 09:30
     startTime.value=parsedCourseSelected.start_hour_schedule.slice(0,5);
     //  END TIME ELEMENT AND SET DATA
     const endTime = document.getElementById("endTime");
     endTime.value=parsedCourseSelected. end_hour_schedule.slice(0,5)
    //  SET ID COURSE ON HIDDEN INPUT FIELD
    const idCourseHidden = document.getElementById("id_schedule");
    idCourseHidden.value = parsedCourseSelected?.id_schedule;
     hideTableContainer();
     updateButtonTextToEdit()
      //  Display form 
     showFormSchedule()
    }
      
  } else {
      alert("You need to select an element first");
  }
}

function updateCourse(){
  var room = document.getElementById("room").value;
  var Code = document.getElementById("Code").value;
  var day = document.getElementById("day").value;
  var time = document.getElementById("time").value;
  var rowSelected = document.querySelector
  (".course-selected");

  const cells=rowSelected.

  getElementsByTagName("td")
  cells[0].innerText=room
  cells[1].innerText=Code
  cells[2].innerText=day
  cells[3].innerText=time

  const scheduleForm=document.querySelector(".edit-form")
  scheduleForm.classList.add("edit-form-hidden")

}


// Button Update Text EDIT - CREATE

const getButtonEditCreate = () => document.getElementById("add-course-button");

const updateButtonTextToEdit = () => {
  const button = getButtonEditCreate();
  button.textContent = "Update Course"
}

const updateButtonTextToCreate = () => {
  const button = getButtonEditCreate();
  button.textContent = "Add Course"
}

// const btnEdit = document.querySelector('.edit-course');

// function editCourse(){
//   alert("edit")
// }

// hideForm button



//   button add new course 

// function showForm (){

//   const formTitle=document.getElementById("formTitle");
//     console.log(formTitle);
//     const courseForm=document.getElementById("courseForm");
//     console.log(courseForm);
    

//     formTitle.classList.remove("hidden");
//     courseForm.classList.remove("hidden");
    

//     const tableContainer=document.getElementById("table-container");
//     tableContainer.classList.add("hidden");
  
// }





// View schedule


function viewSchedule(){
  hideScheduleForm()
  showTableContainer()
};





