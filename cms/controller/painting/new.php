<?php

setlocale(LC_COLLATE, "en_CA");

// Sets the data to be returned
$result = [
    'success' => true,
    'response' => null,
    'error' => ''
];

function setError($message) {
    global $result;
    $result['success'] = false;
    $result['error'] = $message;
}

// Check posted data
if (
    isset($_POST['title'])
    &&  isset($_POST['dimensions'])
    &&  isset($_POST['medium'])
    &&  isset($_POST['medium_fr'])
    &&  isset($_POST['location'])
    &&  isset($_POST['status'])
) {

    // Clean data
    $title      = filter_var($_POST['title']       , FILTER_SANITIZE_STRING);
    $dimensions     = filter_var($_POST['dimensions']      , FILTER_SANITIZE_STRING);
    $medium       = filter_var($_POST['medium']        , FILTER_SANITIZE_STRING);
    $mediumFr      = filter_var($_POST['medium_fr']       , FILTER_SANITIZE_STRING);
    //$location       = filter_var($_POST['location']        , FILTER_SANITIZE_STRING);
    $status         = filter_var($_POST['status']          , FILTER_SANITIZE_NUMBER_INT);

    // Check to see if a title was included
    if (!empty($title)) {
        $newTitle = mb_strtolower($title, 'UTF-8');
    }
    $file = sanitize_html($_FILES['location']);  // file from form
    //echo '<br>$file contents: ';
    //var_dump($file);
    $origName = $file['name'];  // file name from uploaded file
    $origType = $file['type'];  // file type from uploaded file
    $origTempName = $file['tmp_name'];  // file tmp_name from uploaded file
    $origError = $file['error'];  // file location from uploaded file
    $origSize = $file['size'];  // file size from uploaded file

    $fileExt = explode(".", $origName);
    $fileActualExt = strtolower(end($fileExt));  // Capture extension

    $allowed =  array("jpg", "jpeg", "png"); //List of allowed extensions for the images.

    // Valid extension check
    if (in_array($fileActualExt, $allowed)) {
        
        // File upload error check
        if ($origError === 0) {
            
            // Filesize check
            if ($origSize > 20000000) {
                
                $cleanNewTitle = removeAccents($newTitle);
                $imageFullName = $cleanNewTitle . "." . date("j.n.Y.h.i.s") . "." . $fileActualExt;  // Create a unique filename to ensure no overriding
                
                //  Set website root folder path
                $fileDestination = "./../../../images/uploads/" . $imageFullName;
                
                // Opens the database
                include_once('../../database/database.php');
                $dbConn = new DbConnection();
                $painting = $dbConn->painting;
                
                // Verify no duplicates
                if ($painting) {
                
                    // Creates hashes for the current records in the database
                    $paintings = $painting->get();
                    foreach ($paintings as $p) {
                        $hashes[] =
                        $p->name . "," .
                            $p->dimensions . "," .
                            $p->medium . "," .
                            $p->medium_fr . "," .
                            $p->location . "," .
                            $p->status;
                    }
                    $hash = $title . "," . $dimensions . "," . $medium . "," . $mediumFr . "," . $location . "," . $status;
                    
                    if (!in_array($hash, $hashes)) {
                        
                        // Add record to database
                        try {
                            $response = $painting->insert($title, $dimensions, $medium, $medium_fr, $location, $status);
                            if ($response) {
                                
                                // Move file to website root folder
                                if (!move_uploaded_file($origTempName, "." . $fileDestination)) {
                                    setError('Image did not get moved properly.');
                                };
                                
                                $paintingID = $painting->pdo->lastInsertId();
                                $result['response'] = array (
                                    'id' => $paintingID,
                                    'title' => $title,
                                    'dimensions' => $dimensions,
                                    'medium' => $medium,
                                    'medium_fr' => $mediumFr,
                                    'location' => $location,
                                    'status' => $status
                                );
                            }
                        } catch (Exception $e) {
                            setError($e->getMessage());
                        }
                    } else {
                        setError('Duplicate record exists');
                    }
                } else {
                    setError('Error connecting to the database');
                }
            } else {
                setError("The file you are attempting to upload is too large.  The maximum filesize is 20Mb.  Please try again.");
            }
        } else {
            setError("An error occured during the upload.  please verify that your information is correct.");
        }
    } else {
        setError("Invalid file extension.  Please only upload jpg, jpeg or png files.");
    }
} else {
    setError('Problems on input');
}


//  Return result
header('Content-type: application/json');
echo json_encode($result);




















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

