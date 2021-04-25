<?php
  session_start();

  if (isset($_SESSION['userUID'])) {

    $_SESSION['currentPage'] = "gallery";

    if (isset($_POST['recNumber'])) {
      deleteRecord($_POST['recNumber']);
      unset($_POST['recNumber']);
    }

    if (isset($_POST['updNumber'])) {
      updateRecord($_POST['updNumber']);
      unset($_POST['updNumber']);
    }


    require '../includes/dbh.inc.php';

    $sql = 'SELECT `id`, `name`, `dimensions`, `medium`, `medium_fr`, `location`, `status`, `date_added` FROM `paintings` ORDER BY `id` DESC';

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

    $recStatus = '';
    $outputMessage = '';

    // Query to find the record to be deleted and capture the location field
    $sql = "SELECT `status` FROM `paintings` WHERE `id` = " . $recID . ";";

    // Analyze query result and extract the file location
    $result = $link->query($sql);
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $recStatus = $row['status'];
        $outputMessage .= '<p class="text-success font-weight-bold mb-0">Record Found.</p>';
      }
    } else {
      $outputMessage .= '<p class="text-danger font-weight-bold mb-0">Record Not Found.</p>';
    }
    if ($recStatus == 1) {

      // Query to update the record
      $sql = "UPDATE `paintings` SET `status` = 2 WHERE `id` = " . $recID . ";";
    } else if ($recStatus == 2) {

      // Query to update the record
      $sql = "UPDATE `paintings` SET `status` = 1 WHERE `id` = " . $recID . ";";
    }

    if ($link->query($sql) === TRUE) {
      $outputMessage .= '<p class="text-success font-weight-bold mb-0">Record Updated Successfully.</p>';
    } else {
      $outputMessage .= '<p class="text-danger font-weight-bold mb-0">Error Updating Record.</p>';
    }
    echo '<div class="card w-50 mx-auto mt-3 bg-light" style="text-align: center;">
            <div class="card-body">'
              . $outputMessage . '
            </div>
          </div>';

  }

  function deleteRecord($recID) {

    //create a connection
    require '../includes/dbh.inc.php';

    $recLocation = null;  //Create a variable to grab the file location
    $outputMessage = '';

    // Query to find the record to be deleted and capture the location field
    $sql = "SELECT `location` FROM paintings WHERE `id` = " . $recID . ";";

    // Analyze query result and extract the file location
    $result = $link->query($sql);
    if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {
        $recLocation = "." . $row['location'];
        $outputMessage .= '<p class="text-success font-weight-bold mb-0">Record Found.</p>';
        $outputMessage .= '<p class="text-success font-weight-bold mb-0">Record Deleted Successfully.</p>';
      }
      //  Notify if no results found
    } else {
      $outputMessage .= '<p class="text-danger font-weight-bold mb-0">Record Not Found.</p>';
    }

    // Create SQL statement to delete the desired record
    $sql = "DELETE FROM paintings WHERE `id` = " . $recID . ";";

    // Apply query and delete corresponding file if successful

    if ($link->query($sql) === TRUE) {
      if (file_exists($recLocation)) {
        unlink($recLocation);  //Delete corresponding file
        $outputMessage .= '<p class="text-success font-weight-bold mb-0">Image File Deleted Successfully.</p>';
      } else {
        $outputMessage .= '<p class="text-danger font-weight-bold mb-0">Image File Cannot Be Found.  Needs to be delete manually.</p>';
      }
    } else {
      $outputMessage .= '<p class="text-danger font-weight-bold mb-0">Error Deleting Record: ' . $link->error . '.</p>';
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
     <span class="btn btn-primary position-top-left" onclick="addNewImage()">Add New</span>
     <div class="container-fluid">
       <table class="table">
         <thead>
           <tr>
             <th scope="col">ID</th>
             <th scope="col">Title</th>
             <th scope="col">Dimensions</th>
             <th scope="col">Medium</th>
             <th scope="col">Medium(French)</th>
             <th scope="col">Location</th>
             <th scope="col">Status</th>
             <th scope="col">Date Added</th>
             <th scope="col">Thumbnail</th>
             <th scope="col">Delete</th>
           </tr>
         </thead>
         <tbody>';

             if (!isset($result)) {
               echo 'SQL statement not prepared.';
             } else {
               while ($row = mysqli_fetch_assoc($result)) {

                 $recStatus = $row['status'];
                 $btnColor = '';
                 $newAvailability = '';
                 if ($recStatus == 1) {
                   $availability = "Available";
                   $btnColor = "success";
                 } else {
                   $availability = "Unavailable";
                   $btnColor = "danger";
                 }

                 // echo 'Status: ' . $recStatus . '  -  availibility: ' . $availability . '<br>';

                 echo '<tr>
                 <th scope="row">' . $row["id"] . '</th>
                 <td>' . $row["name"] . '</td>
                 <td>' . $row["dimensions"] . '</td>
                 <td>' . $row["medium"] . '</td>
                 <td>' . $row["medium_fr"] . '</td>
                 <td style="max-width:300px; overflow:hidden;">' . $row["location"] . '</td>
                 <td>
                  <form name="updateFormNo' . $row["id"] . '" action="./index.php" onsubmit="return statusChange(' . $row["id"] . ')" method="post">
                    <input type="text" class="custom-control-input" id="togStatus" name="togStatus" value="' . $recStatus . '" hidden>
                    <input type="text" class="custom-control-input" id="updNumber" name="updNumber" value="' . $row['id'] . '" hidden>
                    <input type="text" class="custom-control-input" id="updName" name="updName" value="' . $row['name'] . '" hidden>
                    <button class="btn btn-' . $btnColor . '" type="submit" class="cursor">' . $availability . ' </button>
                  </form>
                 </td>
                 <td>' . $row["date_added"] . '</td>
                 <td>
                 <img class="thumbnail" src=".' . $row["location"] . '" alt="' . $row["name"] . ' Image"/>
                 </td>

                 <td>
                  <form name="deleteFormNo' . $row["id"] . '" action="./index.php" onsubmit="return deleteConfirmation(' . $row["id"] . ')" method="post">
                    <input type="text" name="recNumber" id="recNumber" value="' . $row["id"] . '" hidden>
                    <input type="text" name="recName" id="recName" value="' . $row["name"] . '" hidden>
                    <button class="btn btn-danger delete-btn" type="submit" class="cursor">&times;</button>
                  </form>
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
          <h5 class="modal-title">New Painting Entry Form</h5>
          <button type="button" class="close" onclick="closeModal()" >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="../includes/cms-upload.inc.php" method="post" enctype="multipart/form-data" accept-charset="utf8">
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="txtTitle">Painting Title: </label>
                  <input type="text" class="form-control" id="txtTitle" name="txtTitle" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label style="display: block;">Painting Dimentions: </label>
                    <label for="txtWidth" class="side-by-side">Width: </label>
                    <input type="text" class="form-control control-width side-by-side" id="txtDimensions" name="txtWidth" style="width: 60px;" required>
                  <span class="side-by-side big pl-4 pr-4">x</span>
                    <label for="txtHeight" class="side-by-side">Height: </label>
                    <input type="text" class="form-control control-width side-by-side" id="txtDimensions" name="txtHeight" style="width: 60px;" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="txtMedium">Painting Medium - English:</label>
                  <input type="text" class="form-control" id="txtMedium" name="txtMedium" value="Oil on canvas" required>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="txtMediumFr">Painting Medium - Français:</label>
                  <input type="text" class="form-control" id="txtMediumFr" name="txtMediumFr" value="Huile sur toile" required>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="txtLocation">Painting Image:</label>
              <input type="file" class="form-control" id="txtLocation" name="txtLocation" style="height:45px;" required>
            </div>
            <div class="form-group form-check pl-0">
              <label style="display: block;">Availability: </label>
              <div class="form-borders pt-2">
                <input type="radio" class="form-check-input ml-2" id="statusAvailable" name="status" value="1" required>
                <label class="form-check-label ml-4 mr-5" for="statusAvailable">Available</label>
            <!-- </div> -->
            <!-- <div class="form-group form-check"> -->
                <input type="radio" class="form-check-input" id="statusUnavailable" name="status" value="2">
                <label class="form-check-label" for="statusUnavailable">Unavailable</label>
              </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
