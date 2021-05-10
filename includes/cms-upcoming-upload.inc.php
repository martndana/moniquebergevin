<?php
  session_start();
  // Verify if the post has been received

setlocale(LC_COLLATE, "en_CA");

  if (isset($_POST)) {
    var_dump($_POST);
    $arr_cln = sanitize_html($_POST);

    $newDesc_Fr = $arr_cln['txtDesc_Fr'];  // French Description from form
    $newDesc = $arr_cln['txtDesc'];  // Description from form

    // Status from form
    if ($arr_cln["txtStatus"] == "Active") {
      $newStatus = 1;
    } else if ($arr_cln["txtStatus"] == "Disabled") {
      $newStatus = 0;
    }

    //  Include database connection file
    include_once "./dbh.inc.php";

    // Empty filed check
    if (empty($newDesc) || empty($newDesc_Fr)) {
      header("Location: ../cms/upcoming_cms.php?upload=empty");  // Sends back to original php file
      exit();  // Exit this file
    } else {

      //  Create insert statement and execute it
      $sql = "INSERT INTO upcoming (description, description_fr, status) VALUES (?, ?, ?);";

      $stmt = mysqli_stmt_init($link);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
      } else {

        // Assign values to parameters in insert statement -- each "s" represent a parameter to be captured
        mysqli_stmt_bind_param($stmt, "sss", $newDesc, $newDesc_Fr, $newStatus);

        if (!mysqli_stmt_execute($stmt)) {
          echo 'The record did not get added to the DB.';
        };

        //  Send user back to original page with success result
        header("Location: ../cms/upcoming_cms.php?upload=success");
      }
    }
  }


  // Sanitize the POST
  function sanitize_html($arr) {
      foreach($arr AS $key => $val) {
        $arr_cln[$key] = htmlentities($val, ENT_QUOTES, "UTF-8");
      }
      return $arr_cln;
    }

?>
