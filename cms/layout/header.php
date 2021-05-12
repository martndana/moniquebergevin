<?php

define('ROOT_PATH', str_replace($_SERVER['DOCUMENT_ROOT'], '',  dirname(dirname(__FILE__))) . '/');

// Gets the session
require_once($_SERVER['DOCUMENT_ROOT'] . '/cms/session/user.php');
$userSession = new SessionUser();

// Checks if the user is logged or in the login page
if (!$userSession->isLogged() && $_SERVER['REQUEST_URI'] !== ROOT_PATH) {
    header("Location: " . ROOT_PATH);
    die();
}

// Current page uri
$page = strtolower($_SERVER['REQUEST_URI']);

/**
 * Returns the absolute path for a given URI
 */
function getAbsolutePath(string $uri)
{
    echo ROOT_PATH . $uri;
}

?>

<DOCTYPE html>
<html>
<head>
    <title>Monique - CMS</title>

    <!-- Stylesheets -->
    <link href="<?php getAbsolutePath('css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?php getAbsolutePath('css/fontawesome/all.min.css') ?>" rel="stylesheet" />
    <link href="<?php getAbsolutePath('css/jquery-ui.min.css') ?>" rel="stylesheet" />
    <link href="<?php getAbsolutePath('css/styles.css') ?>" rel="stylesheet" />

    <!-- Scripts -->
    <script src="<?php getAbsolutePath('js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?php getAbsolutePath('js/jquery-ui.min.js') ?>"></script>
    <script src="<?php getAbsolutePath('js/all.min.js') ?>"></script>
    <script src="<?php getAbsolutePath('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php getAbsolutePath('js/scripts.js') ?>"></script>

</head>
<body>
    <header>
        <h1 class="text-center my-3">Content Management System</h1>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <?php if ($userSession->isLogged()) : ?>
                    <a class="navbar-brand" href="<?php getAbsolutePath(''); ?>"><img src="./../../../images/logos/logo.png" alt="Monique Logo" style="width: 50px; height: 50px;"></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item active">
                            <a class="nav-link" href="<?php getAbsolutePath('pages/gallery/index.php'); ?>">Gallery</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="<?php getAbsolutePath('pages/upcoming/index.php'); ?>">Upcoming</a>
                            </li>
                        </ul>

                        <div class="">
                            <span><?php echo $userSession->username; ?></span>
                            <i class="fas fa-user"></i>
                            <a href="<?php getAbsolutePath('login/signout.php'); ?>">Sign Out</a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </nav>
    </header>