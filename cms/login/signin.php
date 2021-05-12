<?php

// Sets the data to be returned
$result = [
    'success'  => false,
    'redirect' => ''
];

// Validates the posted data
if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] !== '' && $_POST['password'] !== '') {

    // Gets the user
    include_once('./../database/database.php');
    $dbConn = new DbConnection();
    $user = $dbConn->user->getLogin($_POST['username'], $_POST['password']);

    if ($user) {

        // Sets the session
        require_once('./../session/user.php');
        $userSession = new SessionUser();

        $userSession->id = $user->idUsers;
        $userSession->username = $user->uidUsers;
        $userSession->save();

        // Sets the result
        $result['success'] = true;
        $result['redirect'] =  str_replace($_SERVER['DOCUMENT_ROOT'], '',  dirname(dirname(__FILE__))) . '/';
    }
}

// Returns the result as json
header('Content-type: application/json');
echo json_encode($result);
