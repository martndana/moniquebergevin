<?php

// Sets the data to be returned
$result = [
    'success'   =>  false,
    'payload'   =>  NULL
];

// Validates the posted data
if (
        isset($_POST['paintingId'])
    ) {

    // sanitize input
    $paintingId = filter_var($_POST['paintingId'], FILTER_SANITIZE_NUMBER_INT);

    // validate variable values
    if ($paintingId != NULL) {

        // Opens the database
        include_once('../../database/database.php');
        $dbConn = new DbConnection();
        // instantiante painting
        $painting = $dbConn->painting;
        $paintingData = $painting->getOne($paintingId);
        $imageLocation = $paintingData[0]->location;
        if ($painting) {
            try {
                $response = $painting->delete($paintingId);
                if ($response) {
                    $result = [
                        'success'       =>  true,
                        'message'       => 'painting data removed'
                    ];
                    // Need to delete the local file
                    if (file_exists($imageLocation)) {
                        unlink($imageLocation);
                    }
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
                    'message'   => 'Painting instance not happened!'
                )
            ];
        }
    } else {
        $result = [
            'success'   =>  false,
            'payload'   =>  array(
                'message'   => 'Problems with painting id provided!'
            )
        ];
    }
} else {
    $result = [
        'success'   =>  false,
        'payload'   =>  array(
            'message'   => 'Painting id was not provided!'
        )
    ];
}

// Returns the result as json
header('Content-type: application/json');
echo json_encode($result);