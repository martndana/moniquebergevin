function addNewEvent() {
  document.getElementById("myModal").style.display = "block";
  document.getElementById("upcomingModal").action = "../includes/cms-upcoming-upload.inc.php";
  document.getElementById("modalTitle").innerHTML = "New Event Entry Form";
  document.getElementById("txtID").innerHTML = "";
  document.getElementById("txtDesc").value = "";
  document.getElementById("txtDesc_Fr").value = "";
  document.getElementById("txtStatus").checked = true;
  document.getElementById("statusLabel").innerHTML = "Active";
}

function addNewImage() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

function deleteConfirmation(recId) {
  let recordID = document.forms['deleteFormNo' + recId]['recNumber'].value;
  let paintingTitle = document.forms['deleteFormNo' + recId]['recName'].value;

  let confResult = confirm('You are about to delete record number ' + recordID + ' titled "' + paintingTitle + '".');
  if (confResult == true) {
    return true;
  } else {
    return false;
  }
}

function statusChange(recId) {
  let currStatus = document.forms['updateFormNo' + recId]['togStatus'].value;
  let recID = document.forms['updateFormNo' + recId]['updNumber'].value;
  let paintingTitle = document.forms['updateFormNo' + recId]['updName'].value;

  let xStatus = "";
  if (currStatus == 2) {
    xStatus = "Available";
  }
  else if (currStatus == 1) {
    xStatus = "Unavailable";
  }
  let xConfirm = confirm('You are about to change the availability of the painting titled "' + paintingTitle + '" to ' + xStatus + '.');
  if (xConfirm == true) {
    return true;
  } else {
    return false;
  }
}
