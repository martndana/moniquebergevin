<?php

// Sets the data to be returned
$result = [
    'success'   =>  false,
    'payload'   =>  NULL
];

// Validates the posted data
if (
    isset($_POST['paintingId'])
    &&  isset($_POST['title'])
    &&  isset($_POST['dimensions'])
    &&  isset($_POST['medium'])
    &&  isset($_POST['medium_fr'])
    &&  isset($_POST['location'])
    &&  isset($_POST['status'])
) {

    // sanitize input
    $paintingId     = filter_var($_POST['paintingId'], FILTER_SANITIZE_NUMBER_INT);
    $title      = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $dimensions     = filter_var($_POST['dimensions'], FILTER_SANITIZE_STRING);
    $medium       = filter_var($_POST['medium'], FILTER_SANITIZE_STRING);
    $mediumFr      = filter_var($_POST['medium_fr'], FILTER_SANITIZE_STRING);
    $location       = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
    $status         = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);

    // validate variable values
    if (
        $paintingId != NULL
        &&  $title  != ''
        &&  $dimensions   != ''
        &&  $medium != ''
        &&  $mediumFr != ''
        &&  $location != ''
        &&  $status >= 1 && $status <= 2
    ) {
        // Opens the database
        include_once('../../database/database.php');
        $dbConn = new DbConnection();
        // instantiante employee
        $painting = $dbConn->painting;
        if ($painting) {

            // Creates hashes for the current records in the database
            $paintings = $painting->get();
            foreach ($paintings as $p) {
                if ($p->id != $paintingId) {
                    $hashes[] =
                        $p->name . "," .
                        $p->dimensions . "," .
                        $p->medium . "," .
                        $p->medium_fr . "," .
                        $p->location . "," .
                        $p->status;
                }
            }
            $hash = $title . "," . $dimension . "," . $medium . "," . $mediumFr . "," . $location . "," . $status;

            if (!in_array($hash, $hashes)) {

                try {
                    $response = $painting->update($paintingId, $title, $dimensions, $medium, $mediumFr, $location, $status);
                    if ($response) {
                        $paintingData = $painting->getOne($paintingId);
                        $result = [
                            'success'       =>  true,
                            'message'       => 'painting data updated',
                            'payload'       => array(
                                'data'  => array(
                                    'title'        =>  $paintingData[0]->name,
                                    'dimensions'      =>  $paintingData[0]->dimensions,
                                    'medium'       =>  $paintingData[0]->medium,
                                    'medium_fr'       =>  $paintingData[0]->medium_fr,
                                    'location'          =>  $paintingData[0]->location,
                                    'status'        =>  $paintingData[0]->status,
                                )

                            )
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
                        'message'   => 'Duplicate record exists'
                    )
                ];
            }
        } else {
            $result = [
                'success'   =>  false,
                'payload'   =>  array(
                    'message'   => 'painting instance not happened'
                )
            ];
        }
    } else {
        $result = [
            'success'   =>  false,
            'payload'   =>  array(
                'message'   => 'problems on validation'
            )
        ];
    }
} else {
    $result = [
        'success'   =>  false,
        'payload'   =>  array(
            'message'   => 'problems on input'
        )
    ];
}

// Returns the result as json
header('Content-type: application/json');
echo json_encode($result);
