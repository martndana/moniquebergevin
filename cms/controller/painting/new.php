<?php

setlocale(LC_COLLATE, "en_CA");

// Sets the data to be returned
$result = [
    'success' => true,
    'response' => NULL,
    'error' => ''
];

function setError($message) {
    global $result;
    $result['success'] = false;
    $result['error'] = $message;
}

// Check posted data

if (
    isset($_POST['inputTitleNew'])
    &&  isset($_POST['inputDimensionsNew'])
    &&  isset($_POST['inputMediumNew'])
    &&  isset($_POST['inputMediumFrNew'])
    &&  isset($_FILES['inputLocationNew'])
    &&  isset($_POST['inputStatusNew'])
) {

    // Clean data
    $title          = filter_var($_POST['inputTitleNew']       , FILTER_SANITIZE_STRING);
    $dimensions     = filter_var($_POST['inputDimensionsNew']      , FILTER_SANITIZE_STRING);
    $medium         = filter_var($_POST['inputMediumNew']        , FILTER_SANITIZE_STRING);
    $mediumFr       = filter_var($_POST['inputMediumFrNew']       , FILTER_SANITIZE_STRING);
    $fileName       = filter_var($_FILES['inputLocationNew']['name']        , FILTER_SANITIZE_STRING);  // file from form
    $fileSize       = filter_var($_FILES['inputLocationNew']['size']        , FILTER_SANITIZE_NUMBER_INT);  // file from form
    $location       = filter_var($_FILES['inputLocationNew']['tmp_name']        , FILTER_SANITIZE_STRING);
    $status         = filter_var($_POST['inputStatusNew']          , FILTER_SANITIZE_NUMBER_INT);
    $dimensions     = mb_strtolower($dimensions, 'UTF-8');


    $newTitle = mb_strtolower($title, 'UTF-8');
    $origName = $fileName;  // file name from uploaded file
    $origSize = $fileSize;  // file size from uploaded file

    $fileExt = explode(".", $origName);
    $fileActualExt = strtolower(end($fileExt));  // Capture extension

    $allowed =  array("jpg", "jpeg", "png"); //List of allowed extensions for the images.

    // Valid extension check
    if (in_array($fileActualExt, $allowed)) {
        
        // File upload error check
        // if ($file) {
            
            // Filesize check
            if ($origSize <= 20000000) {
                
                $cleanNewTitle = removeAccents($newTitle);
                $imageFullName = $cleanNewTitle . "." . date("j.n.Y.h.i.s") . "." . $fileActualExt;  // Create a unique filename to ensure no overriding
                
                //  Set website root folder path
                $fileDestination = "../../../images/uploads/" . $imageFullName;
                
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
                            $p->status;
                    }
                    $hash = $title . "," . $dimensions . "," . $medium . "," . $mediumFr . "," . $status;
                    
                    if (!in_array($hash, $hashes)) {
                        
                        // Move file to website root folder
                        if (move_uploaded_file($location, $fileDestination)) {
                            // Add record to database
                            try {
                                $response = $painting->insert($title, $dimensions, $medium, $mediumFr, $fileDestination, $status);
                                if ($response) {
                                    
                                    
                                    $paintingID = $painting->pdo->lastInsertId();
                                    $newPainting = $painting->getOne($paintingID);
                                    $result['response'] = array (
                                        'id' => $paintingID,
                                        'title' => $title,
                                        'dimensions' => $dimensions,
                                        'medium' => $medium,
                                        'medium_fr' => $mediumFr,
                                        'location' => $fileDestination,
                                        'status' => $status,
                                        'date_added' => $newPainting[0]->date_added
                                );
                            }
                            } catch (Exception $e) {
                                if (file_exists($imageLocation)) {
                                    unlink($imageLocation);
                                }
                                setError($e->getMessage());
                            }
                        } else {
                            setError('Image did not get moved properly.');
                        };
                    } else {
                        setError('Duplicate record exists');
                    }
                } else {
                    setError('Error connecting to the database');
                }
            } else {
                setError("The file you are attempting to upload is too large.  The maximum filesize is 20Mb.  Please try again.");
            }
        // } else {
            // setError("An error occured during the upload.  please verify that your information is correct.");
        // }
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

    $dirtyStr = strtr(utf8_decode($dirtyStr), utf8_decode($badChars), $goodChars);  // Replace special characters

    $cleanStr = '';
    $length = mb_strlen($dirtyStr, "UTF-8");
    $validChars = '_abcdefghijklmnopqrstuvwxyz0123456789';
    for ($i = 0; $i < $length; $i++) {
        if (strpos($validChars, $dirtyStr[$i]) >= 0) {
            $cleanStr .= $dirtyStr[$i];
        }
    }
// echo '<br>' . $dirtyStr;
return $cleanStr;

}

?>