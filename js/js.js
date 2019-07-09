// Get the modal
var modalLog = document.getElementById("modalLog");

var modalreg = document.getElementById("modalReg")

// Get the button that opens the modal
var log = document.getElementById("log");

var reg = document.getElementById("reg")

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var span2 = document.getElementsByClassName("close")[1];

// When the user clicks on the button, open the modal 
log.onclick = function() {
  modalLog.style.display = "block";
}

reg.onclick = function() {
	modalReg.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modalLog.style.display = "none";
}

span2.onclick = function() {
  modalReg.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modalLog) {
    modalLog.style.display = "none";
  }
  else if (event.target == modalReg) {
  	modalReg.style.display = "none";
  }
}
