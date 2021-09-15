
<?php  
    /* index.php
     * Description: Landing page for Content Management System 
     * Author: Martin Bergevin
    */

    // Load the header
    include_once('./layout/header.php');

    $userSession = new SessionUser();
?>

<div class="container min-height-container d-flex justify-content-center align-items-center mt-5">
    <?php if ($userSession->isLogged()) : ?>
        <div class="text-center">
            <h2>Welcome</h2>
            <div>Select an option on the menu above.</div>
        </div>
    <?php else : ?>
        <div class="card">
            <!-- Error Message -->
            <div id="errorMessage" class="alert alert-danger" style="display: none"></div>

            <!-- Login Form -->
            <div class="card-body">
                <form style="width: 300px;">
                    <div class="form-group mb-4">
                        <label for="username" class="mb-0">Username:</label>
                        <input type="text" class="form-control" id="username" />
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="mb-0">Password:</label>
                        <input type="password" class="form-control" id="password" />
                    </div>
                    <button id="buttonLogin" type="button" class="btn btn-primary" onclick="login()">Login</button>
                    <button id="buttonLoading" class="btn btn-secondary" type="button" style="display: none;" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </form>
            </div>
        </div>
    <?php endif ?>
</div>

<!-- Scripts -->
<script src="./login/scripts.js"></script>

<!-- Load Footer -->
<?php  include_once('./layout/footer.php'); ?>


