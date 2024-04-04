
  document.getElementById('floor').addEventListener('mousedown',function(e){
    this.style.cursor='grabbing';
  });
  document.getElementById('floor').addEventListener('mouseup',function(e){
    this.style.cursor='grab';
  });
 

  rooms.forEach(room => {
    const roomElement = document.getElementById(room.code_room);
    if (roomElement) { // Check if the element exists
        let class_room='room';
        if(_JS_VAR_disabled=='on'){
            class_room='greyscale';
            roomElement.classList.add(class_room);
        }else{
            roomElement.classList.add(class_room);
            roomElement.addEventListener('click', () => {
                // roomElement.classList.toggle('active');
                parent.window.location='room.php?id='+room.id_room;
                 //alert(`CODE=${room.code_room} ID=${room.id_room}`);
               });
        }
       

    }
  });

  if(_JS_VAR_active_room){
    const active_room = _JS_VAR_active_room.split(',');
    active_room.forEach(roomId => {
        const roomElement = document.getElementById(roomId);
        if (roomElement) { // Check if the element exists
        //    console.log(roomElement);
            roomElement.classList.add('active');
        //   roomElement.addEventListener('click', () => {
        //     roomElement.classList.toggle('active');
        //   });
        }
    });
  }
