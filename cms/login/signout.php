<?php


// Sets the session
require_once('./../session/user.php');
$userSession = new SessionUser();
$userSession->clear();

session_destroy();

header("Location: " . str_replace($_SERVER['DOCUMENT_ROOT'], '',  dirname(__DIR__)) . '/');
