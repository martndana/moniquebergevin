<?php
  session_start();

  if (isset($_SESSION['userUID'])) {

    $_SESSION['currentPage'] = "upcoming";

    if (isset($_GET['updateRec'])) {
      // var_dump($_POST);  // Test to see what value comes back for the checkbox
      updateRecord($_POST['txtID']);
      unset($_GET['updateRec']);
    }


    require '../includes/dbh.inc.php';

    $sql = 'SELECT `id`, `description`, `description_fr`, `status` FROM `upcoming` ORDER BY `id` DESC';

    $result = null;
    $stmt = mysqli_stmt_init($link);

    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
    }


  } else {
    header("Location: ./login.php");
    exit();
  }

  function updateRecord($recID) {

    //create a connection
    require '../includes/dbh.inc.php';

    $outputMessage = '';

    $newStatus = "";
    if ($_POST['txtStatus'] == "Active") {
      $newStatus = 1;
    }
    else if ($_POST['txtStatus'] == "Disabled") {
      $newStatus = 0;
    }

    // Create SQL statement to update the desired record
    $sql = "UPDATE `upcoming` SET `description` = \"" . $_POST['txtDesc'] . "\", `description_fr` = \"" . $_POST['txtDesc_Fr'] . "\", `status` = " . $newStatus . " WHERE `id` = " . $recID . ";";
    // Apply query and delete corresponding file if successful

    if ($link->query($sql) === TRUE) {
      $outputMessage .= '<p class="text-success font-weight-bold mb-0">Record Updated Successfully.</p>';
    } else {
      $outputMessage .= '<p class="text-danger font-weight-bold mb-0">Error Updating Record: ' . $link->error . '.</p>';
    }
    echo '<div class="card w-50 mx-auto mt-3 bg-light" style="text-align: center;">
  <div class="card-body">'
     . $outputMessage . '
    </div>
  </div>';
  }

  if (isset($_GET['upload'])) {
    echo '<div class="card w-50 mx-auto mt-3 bg-success" style="text-align: center;">
    <div class="card-body">
      <p class="font-weight-bold px-4 mb-0">New Record Successfully Added.</p>
    </div>
  </div>';
  }


?>


 <!doctype html>
 <html lang="en">
   <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <link rel="stylesheet" href="../css/cmsstyle.css">
     <link rel="icon" href="../images/icons/favicon.ico" type="image/x-icon">
     <link rel="shortcut icon" href="../images/icons/favicon.ico" type="image/x-icon">
     <script type="text/javascript" src="../js/cms_main.js"></script>
     <title>Monique - CMS</title>
   </head>
   <body>
     <script>
       function editRecord(recString) {
         let recArray = recString.split("|");
         console.log(recArray[0]);
         document.getElementById("myModal").style.display = "block";
         document.getElementById("modalTitle").innerHTML = "Update Existing Record";
         document.getElementById("txtID").value = recArray[0];
         document.getElementById("txtDesc").value = recArray[1];
         document.getElementById("txtDesc_Fr").value = recArray[2];
         document.getElementById("txtStatus").value = recArray[3];
         console.log(document.getElementById("txtID").value);
         // if (recArray[3] == 1) {
         //   document.getElementById("txtStatus").checked = true;
         //   document.getElementById("statusLabel").innerHTML = "Active";
         // } else {
         //   document.getElementById("txtStatus").checked = false;
         //   document.getElementById("statusLabel").innerHTML = "Inactive";
         // }
         document.getElementById("submitBtn").innerHTML = "Save Changes";
         document.getElementById("upcomingModal").action = "./upcoming_cms.php?updateRec=true";
       };

       function statusChange() {
         let currentStatus = document.getElementById("txtStatus").checked;
          document.getElementById("statusLabel").innerHTML = (currentStatus)?"Active":"Inactive";
       }

     </script>

     <h1>Monique - Content Management System</h1>

     <?php require './cms_nav.php'; ?>

     <?php
     if (!isset($_SESSION['userID'])) {
       echo '<div class="mx-auto" style="text-align:center"><p>You are not currently logged into the content management system.</p>
       <form class="form-group" action="./login.php" method="post">
       <button type="submit" class="btn btn-primary text-uppercase font-weight-bold" name="login-redirect">Go To Login Screen</button>
       </form></div>';
     } else {
     echo '<div id="logoutArea">
       <form class="" action="../includes/logout.inc.php" method="post">
         <button class="btn btn-primary text-uppercase font-weight-bold" type="submit" name="logout-submit">Logout</button>
       </form>
     </div>
     <span class="btn btn-primary position-top-left" onclick="addNewEvent()">Add New</span>
     <div class="container-fluid">
       <table class="table">
         <thead>
           <tr>
             <th scope="col">ID</th>
             <th scope="col">Description</th>
             <th scope="col">French Description</th>
             <th scope="col">Status</th>
             <th scope-"col">Edit</th>
           </tr>
         </thead>
         <tbody>';

             if (!isset($result)) {
               echo 'SQL statement not prepared.';
             } else {
               while ($row = mysqli_fetch_assoc($result)) {

                 $tempID = $row["id"];
                 $tempDesc = $row["description"];
                 $tempDescFr = $row["description_fr"];
                 $tempStatus = "";
                 if ($row['status'] == 0) {
                   $tempStatus = "Disabled";
                 }
                 else if ($row['status'] == 1) {
                   $tempStatus = "Active";
                 }

                 $modalString = $tempID . "|" . $tempDesc . "|" . $tempDescFr . "|" . $tempStatus;

                 echo '<tr>
                 <th scope="row">' . $row["id"] . '</th>
                 <td>' . $row["description"] . '</td>
                 <td>' . $row["description_fr"] . '</td>
                 <td>' . $tempStatus . '</td>
                 <td>
                  <button class="btn btn-primary delete-btn px-0 pt-1" onclick="editRecord(\'' . $modalString . '\')"><img src="../images/icons/edit.png" style="width:25px;height:25px;border-radius:3px;" /></button>
                 </td>
                </tr>';

               }
             }
           }
         ?>

         </tbody>
       </table>
     </div>

    <div id="myModal" style="display:none;">
      <div class="container modal-content">
        <div class="modal-header">
          <h5 id="modalTitle" class="modal-title">New Upcoming Event Entry Form</h5>
          <button type="button" class="close" onclick="closeModal()" >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="upcomingModal" action="../includes/cms-upcoming-upload.inc.php" method="post" enctype="multipart/form-data" accept-charset="utf8">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="txtDesc">Event Description: </label>
                  <input type="text" class="form-control" id="txtDesc" name="txtDesc" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="txtDesc_Fr">Event Description (French): </label>
                  <input type="text" class="form-control" id="txtDesc_Fr" name="txtDesc_Fr" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-2">
                <div class="form-group">
                  <div class="form-group">
                    <label for="txtStatus">Status: </label>
                    <select class="form-control" id="txtStatus" name="txtStatus">
                      <option name="Active">Active</option>
                      <option name="Disabled">Disabled</option>
                    </select>
                  </div>
                  <!-- <input type="checkbox" class="form-control side-by-side pl-4" id="txtStatus" name="txtStatus"  onclick="statusChange()" style="width: 20px;height: 20px;">
                  <label id="statusLabel" for="txtStatus" class="side-by-side"> Visible on Website</label> -->
                </div>
              </div>
            </div>
            <input type="text" id="txtID" name="txtID" hidden></input>
            <button type="submit" id="submitBtn" name="submit" class="btn btn-primary">Submit</button>

          </form>
        </div>
      </div>
    </div>

    <?php require '../footer.php'; ?>

     <!-- Optional JavaScript -->
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
   </body>
 </html>
