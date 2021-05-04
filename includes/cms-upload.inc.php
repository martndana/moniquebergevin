<?php
  session_start();
  // Verify if the post has been received

setlocale(LC_COLLATE, "en_CA");

  if (isset($_POST)) {
    $arr_cln = sanitize_html($_POST);
    $currTitle = $_POST['txtTitle'];

    echo '$currTitle: ';
    var_dump($currTitle);
    echo '<br>$currTitle encoding Format: ' . mb_detect_encoding($currTitle);
    echo '<br>$currTitle length: ' . mb_strlen($currTitle);

    // Check to see if a title was included
    if (empty($currTitle)) {
      $newTitle = "gallery";  // Set a default title if none entered
    } else {
      $newTitle = mb_strtolower($currTitle, 'UTF-8');
      // $newTitle = strtolower(str_replace(" ", "_", utf8_decode($currTitle)));
      echo '<br>$newTitle after spaces replaced: ' . $newTitle;
    }
    $newDimensions = $arr_cln['txtWidth'] . " x " . $arr_cln['txtHeight'];  // Dimensions from form
    $newMedium = $arr_cln['txtMedium'];  // Medium from form
    $newMediumFr = $arr_cln['txtMediumFr'];  // Medium_fr from form
    $newStatus = $arr_cln['status'];  // Status from form
    // var_dump($_FILES) . '<br><br>';
    $file = sanitize_html($_FILES['txtLocation']);  // file from form
    echo '<br>$file contents: ';
    var_dump($file);
    $origName = $file['name'];  // file name from uploaded file
    $origType = $file['type'];  // file type from uploaded file
    $origTempName = $file['tmp_name'];  // file tmp_name from uploaded file
    $origError = $file['error'];  // file location from uploaded file
    $origSize = $file['size'];  // file size from uploaded file

    $fileExt = explode(".", $origName);
    $fileActualExt = strtolower(end($fileExt));  // Capture extension

    $allowed =  array("jpg", "jpeg", "png"); //List of allowed extensions for the images.

    // Valid extension check
    if (!in_array($fileActualExt, $allowed)) {
      echo "Invalid file extension.  Please only upload jpg, jpeg or png files.";
      exit();
    } else {

      // File upload error check
      if (!$origError === 0) {
        echo "An error occured during the upload.  please verify that your information is correct.";
        exit();
      } else {

        // Filesize check
        if ($origSize > 20000000) {
          echo "The file you are attempting to upload is too large.  The maximum filesize is 20Mb.  Please try again.";
          exit();
        } else {

          $cleanNewTitle = removeAccents($newTitle);

          echo '<br>$newTitle: ' . $newTitle;
          echo '<br>$cleanNewTitle: ' . $cleanNewTitle;

          $imageFullName = $cleanNewTitle . "." . uniqid("", false) . "." . $fileActualExt;  // Create a unique filename to ensure no overriding

          //  Set website root folder path
          $fileDestination = "./images/uploads/" . $imageFullName;

          //  Include database connection file
          include_once "./dbh.inc.php";

          // Empty filed check
          if (empty($newTitle) || empty($newDimensions) || empty($newMedium) || empty($newMediumFr) || empty($newStatus)) {
            header("Location: ../cms/index.php?upload=empty");  // Sends back to original php file
            exit();  // Exit this file
          } else {

            //  Create insert statement and execute it
            $sql = "INSERT INTO paintings (name, dimensions, medium, medium_fr, location, status) VALUES (?, ?, ?, ?, ?, ?);";

            $stmt = mysqli_stmt_init($link);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "SQL statement failed";
            } else {

              // Assign values to parameters in insert statement -- each "s" represent a parameter to be captured
              mysqli_stmt_bind_param($stmt, "ssssss", $currTitle, $newDimensions, $newMedium, $newMediumFr, $fileDestination, $newStatus);

              if (!mysqli_stmt_execute($stmt)) {
                echo 'The file did not get added to the DB.';
              };

              // Move file to website root folder
              if (!move_uploaded_file($origTempName, "." . $fileDestination)) {
                echo 'Image did not get moved properly.';
              };

              //  Send user back to original page with success result
              header("Location: ../cms/index.php?upload=success");
            }
          }
        }
      }
    }
  } else {
    var_dump($_FILES);
  }

  // Sanitize the POST
  function sanitize_html($arr) {
      foreach($arr AS $key => $val) {
        $arr_cln[$key] = htmlentities($val, ENT_QUOTES, "UTF-8");
      }
      return $arr_cln;
    }

    // Remove Accents
    function removeAccents($dirtyStr) {

      $dirtyStr = trim($dirtyStr);  //  Remove unecessary spaces

      $badChars = "' -àáâãäçèéêëìíîïñòóôõöùúûüýÿ";
      $goodChars = "___aaaaaceeeeiiiinooooouuuuyy";

      echo '<br>$dirtyStr encoding format: ' . $dirtyStr . ' - ' . mb_detect_encoding($dirtyStr) . '(' . mb_strlen($dirtyStr) . ')';
      echo '<br>$badChars encoding format: ' . $badChars . ' - ' . mb_detect_encoding($badChars) . '(' . mb_strlen($badChars) . ')';
      echo '<br>$goodChars encoding format: ' . $goodChars . ' - ' . mb_detect_encoding($goodChars) . '(' . mb_strlen($goodChars) . ')';

      $dirtyStr = strtr(utf8_decode($dirtyStr), utf8_decode($badChars), $goodChars);  // Replace special characters

      // $badCharsLength = strlen($badChars);
      // echo 'String length: ' . $badCharsLength;
      // for ($x = 0; $x < $badCharsLength; $x++) {
      //   $dirtyStr = str_replace($badChars[$x], $goodChars[$x], $dirtyStr);
      // }

      // echo '<br>' . $dirtyStr;

      $cleanStr = '';
      $length = mb_strlen($dirtyStr, "UTF-8");
      $validChars = '_abcdefghijklmnopqrstuvwxyz0123456789';
      echo '<br>$dirtyStr before erroneous character check: ' . $dirtyStr;
      for ($i = 0; $i < $length; $i++) {
        if (strpos($validChars, $dirtyStr[$i]) >= 0) {
          $cleanStr .= $dirtyStr[$i];
        }

      }
      // echo '<br>' . $dirtyStr;
      return $cleanStr;

    }



  ?>
