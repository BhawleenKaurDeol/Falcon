  document.querySelector('#button-menu').addEventListener("click", function (e) {
    document.querySelector('#layers-menu').classList.toggle("active");
    document.querySelector('#accessible-label').focus();
  });
  //hide on clicking outside
  // window.addEventListener('click', function(e){   
  //   if (document.getElementById('layers-menu').contains(e.target)){
  //     // Clicked in box
  //   } else{
  //     document.querySelector('#layers-menu').classList.remove("active");
  //   }
  // });

  document.querySelector('#accessible-label').addEventListener("click", function (e) {
    document.querySelector('#accesibility').classList.toggle("hide");
    document.querySelector('#accessible-label .cls-14').classList.toggle("hide");
  });
  document.querySelector('#security-label').addEventListener("click", function (e) {
    document.querySelector('#security').classList.toggle("hide");
    document.querySelector('#security-label .cls-14').classList.toggle("hide");
  });
  document.querySelector('#bookstore-label').addEventListener("click", function (e) {
    document.querySelector('#bookstore').classList.toggle("hide");
    document.querySelector('#bookstore-label .cls-14').classList.toggle("hide");
  });

  document.querySelector('#motorcycle-label').addEventListener("click", function (e) {
    document.querySelector('#motorcycle').classList.toggle("hide");
    document.querySelector('#motorcycle-label .cls-14').classList.toggle("hide");
  });

  document.querySelector('#ev-label').addEventListener("click", function (e) {
    document.querySelector('#ev-charging').classList.toggle("hide");
    document.querySelector('#ev-label .cls-14').classList.toggle("hide");
  });

  document.querySelector('#parking-label').addEventListener("click", function (e) {
    document.querySelector('#parking').classList.toggle("hide");
    document.querySelector('#parking-label .cls-14').classList.toggle("hide");
  });

  document.querySelector('#bike-label').addEventListener("click", function (e) {
    document.querySelector('#bikes').classList.toggle("hide");
    document.querySelector('#bike-label .cls-14').classList.toggle("hide");
  });

  document.querySelector('#bus-label').addEventListener("click", function (e) {
    document.querySelector('#bus-stop').classList.toggle("hide");
    document.querySelector('#bus-label .cls-14').classList.toggle("hide");
  });

  document.querySelector('#food-label').addEventListener("click", function (e) {
    document.querySelector('#food').classList.toggle("hide");
    document.querySelector('#food-label .cls-14').classList.toggle("hide");
  });
  