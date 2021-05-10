<?php

// Sets the data to be returned
$result = [
    'success'   =>  false,
    'payload'   =>  NULL
];

// Validates the posted data
if (
        isset($_POST['upcomingId'])
    ) {

    // sanitize input
    $upcomingId = filter_var($_POST['upcomingId'], FILTER_SANITIZE_NUMBER_INT);

    // validate variable values
    if ($upcomingId != NULL) {
        // Opens the database
        include_once('../../database/database.php');
        $dbConn = new DbConnection();
        // instantiante upcoming
        $upcoming = $dbConn->upcoming;
        $upcomingData = $upcoming->getOne($upcomingId);
        if ($upcoming) {
            try {
                $response = $upcoming->delete($upcomingId);
                if ($response) {
                    $result = [
                        'success'       =>  true,
                        'message'       => 'Upcoming data removed'
                    ];
                }
            } catch (Exception $e) {
                $result = [
                    'success'   =>  false,
                    'payload'   =>  array(
                        'message'   => $e->getMessage()
                    )
                ];
            }
        } else {
            $result = [
                'success'   =>  false,
                'payload'   =>  array(
                    'message'   => 'Upcoming instance not happened!'
                )
            ];
        }
    } else {
        $result = [
            'success'   =>  false,
            'payload'   =>  array(
                'message'   => 'Problems with upcoming id provided!'
            )
        ];
    }
} else {
    $result = [
        'success'   =>  false,
        'payload'   =>  array(
            'message'   => 'Upcoming id was not provided!'
        )
    ];
}

// Returns the result as json
header('Content-type: application/json');
echo json_encode($result);