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
    isset($_POST['inputDescNewUpcoming'])
    &&  isset($_POST['inputDescFrNewUpcoming'])
    &&  isset($_POST['inputStatusNewUpcoming'])
) {

    // Clean data
    $description    = filter_var($_POST['inputDescNewUpcoming']      , FILTER_SANITIZE_STRING);
    $descriptionFr  = filter_var($_POST['inputDescFrNewUpcoming']    , FILTER_SANITIZE_STRING);
    $status         = filter_var($_POST['inputStatusNewUpcoming']    , FILTER_SANITIZE_NUMBER_INT);
                
    // Opens the database
    include_once('../../database/database.php');
    $dbConn = new DbConnection();
    $upcoming = $dbConn->upcoming;
    
    // Verify no duplicates
    if ($upcoming) {
    
        // Creates hashes for the current records in the database
        $upcomings = $upcoming->get();
        foreach ($upcomings as $u) {
            $hashes[] =
                $u->description . "," .
                $u->description_fr . "," .
                $u->status;
        }
        $hash = $description . "," . $descriptionFr . "," . $status;
        
        if (!in_array($hash, $hashes)) {
            
            // Add record to database
            try {
                $response = $upcoming->insert($description, $descriptionFr, $status);
                if ($response) {

                    $upcomingID = $upcoming->pdo->lastInsertId();
                    $result['response'] = array (
                        'id' => $upcomingID,
                        'description' => $description,
                        'description_fr' => $descriptionFr,
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
    setError('Problems on input');
}

//  Return result
header('Content-type: application/json');
echo json_encode($result);

?>