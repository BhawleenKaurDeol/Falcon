function watchForHover() {
    // lastTouchTime is used for ignoring emulated mousemove events
    let lastTouchTime = 0
  
    function enableHover() {
      if (new Date() - lastTouchTime < 500) return
      document.body.classList.add('hasHover')
    }
  
    function disableHover() {
      document.body.classList.remove('hasHover')
    }
  
    function updateLastTouchTime() {
      lastTouchTime = new Date()
    }
  
    document.addEventListener('touchstart', updateLastTouchTime, true)
    document.addEventListener('touchstart', disableHover, true)
    document.addEventListener('mousemove', enableHover, true)
  
    enableHover()
  }
  
  watchForHover();

  //offline mode


  function error_message(error_msg){
    Swal.fire({
        title: 'Error!',
        text: error_msg,
        icon: 'error',
        showCloseButton: true,
        denyButtonText: `OK`
      });   
  }
  // function confirm_favorite(id_room,name_room){
  //   Swal.fire({
  //       title: "Do you want to add "+name_room+" to your favorites?",
  //       showDenyButton: false,
  //       showCancelButton: true,
  //       confirmButtonText: "Yes",
  //       cancelButtonText: "No"
  //     }).then((result) => {
  //       /* Read more about isConfirmed, isDenied below */
  //       if (result.isConfirmed) {
  //        // Swal.fire("Saved!", "", "success");
  //        //call API to save
  //       } 
  //     });
  // }

  async function addPreference(id_user, id_room, code_room){
    try {
      const res = await fetch(
        "api.php?id=" + id_user + "&room="+id_room+"&t=preferences-User-RoomId&token=XXX",
        {
          method: 'POST',
          body: {},
        },
      );
    
      const resData = await res.json();
    
      console.log(resData);
    
      if(resData.result=='true'){
            // window.location.replace("profile.php");
            // document.querySelector('#btn-favorites').classList.remove('btn-circle');
            // document.querySelector('#btn-favorites').classList.add('btn-circle-selected');
            // document.querySelector('#btn-favorites i').classList.remove('fa-regular');
            // document.querySelector('#btn-favorites i').classList.add('fa-solid');

            console.log('Selected');
            Swal.fire({
              title: "Room "+code_room+" has been added!",
              text: "The room has been saved into your preferences.",
              icon: "success",
              timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading();
  },
  willClose: () => {
    window.location.reload();
  }
            });

         }else{
          // document.querySelector('#btn-favorites').classList.add('btn-circle');
          //   document.querySelector('#btn-favorites').classList.remove('btn-circle-selected');
          //   document.querySelector('#btn-favorites i').classList.add('fa-regular');
          //   document.querySelector('#btn-favorites i').classList.remove('fa-solid');
          console.log('Not selected');
          Swal.fire({
            title: "Room "+code_room+" has been removed!",
            text: "The room been removed from your favorites.",
            icon: "info",
            timer: 2000,
timerProgressBar: true,
didOpen: () => {
  Swal.showLoading();
},
willClose: () => {
  window.location.reload();
}
          });
       //      alert('There was an error');
         }
    } catch (err) {
      console.log(err.message);
    }
  }
  async function delPreference(id_user, id_room, code_room){
    console.log("api.php?id=" + id_user + "&room="+id_room+"&t=Delpreferences-User-RoomId&token=XXX");
    try {
      const res = await fetch(
        "api.php?id=" + id_user + "&room="+id_room+"&t=Delpreferences-User-RoomId&token=XXX",
        {
          method: 'POST',
          body: {},
        },
      );
    
      const resData = await res.json();
    
      console.log(resData);
    
      if(resData.result=='true'){
            console.log('Selected');
            Swal.fire({
              title: "Room "+code_room+" has been removed!",
              text: "The room been removed from your favorites.",
              icon: "info",
              timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading();
  },
  willClose: () => {
    window.location.reload();
  }
            });
    

         }else{
         
        //  console.log('Not selected');
          Swal.fire({
            title: "There was an error on deleting room"+code_room+"!",
            text: "The room could not be removed from your preferences, please try again",
            icon: "info"
          });
         }
    } catch (err) {
      console.log(err.message);
    }
  }
  function confirm_del_preference(id_user,id_room,code_room){
    Swal.fire({
title: "Are you sure you want to remove "+code_room+" from your preferences?",
text: "You won't be able to revert this, unless you find the room and add it again.",
icon: "warning",
showCancelButton: true,
confirmButtonColor: "#3085d6",
cancelButtonColor: "#d33",
confirmButtonText: "Yes, remove it!"
}).then((result) => {
if (result.isConfirmed) {
  delPreference(id_user, id_room, code_room); 
}
});
    }
  
    function load_page_dom(page,target){
      if(target!='_top'){
    element=document.querySelector(target);
    console.log(element);
    element.innerHTML='<object type="text/html" data="'+page+'" style="width:100%; height:100%;" ></object>';
      }else{
        parent.window.location=page;
      }
    }