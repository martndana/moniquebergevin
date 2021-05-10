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
    isset($_POST['upcomingId'])
    &&  isset($_POST['inputDescEditUpcoming'])
    &&  isset($_POST['inputDescFrEditUpcoming'])
    &&  isset($_POST['inputStatusEditUpcoming'])
) {

    // Clean data
    $upcomingId     = filter_var($_POST['upcomingId']               , FILTER_SANITIZE_NUMBER_INT);
    $description    = filter_var($_POST['inputDescEditUpcoming']    , FILTER_SANITIZE_STRING);
    $descriptionFr = filter_var($_POST['inputDescFrEditUpcoming']  , FILTER_SANITIZE_STRING);
    $status         = filter_var($_POST['inputStatusEditUpcoming']  , FILTER_SANITIZE_NUMBER_INT);

    // Opens the database
    include_once('../../database/database.php');
    $dbConn = new DbConnection();
    $upcoming = $dbConn->upcoming;
    
    if ($upcoming) {
        // Add record to database
        try {
            $response = $upcoming->update($upcomingId, $description, $descriptionFr, $status);
            if ($response) {
                $result['response'] = array (
                    'id' => $upcomingId,
                    'description' => $description,
                    'description_fr' => $descriptionFr,
                    'status' => $status
                );
            }
        } catch (Exception $e) {
            setError($e->getMessage());
        }
    } else {
        setError('Error connecting to the database');
    }
} else {
    setError('Problems on input');
}

//  Return result
header('Content-type: application/json');
echo json_encode($result);



?>