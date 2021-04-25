<?php
// session_start()
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="icon" href="../images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../images/icons/favicon.ico" type="image/x-icon">
    <title>Monique - CMS Login</title>
  </head>
  <?php
    if (isset($_GET['error'])) {
      echo '<div class="card w-50 mx-auto mt-3 bg-danger" style="text-align: center;">
    <div class="card-body">
      <p class="card-text" style="color: #fff;">The following error occured: <br><b>    - ' . $_GET['error'] . '</p>
    </div>
  </div>';};
  ?>

  <body  style="background-color: #FFFEF2">
    <div style="width: 50%; margin: 8% auto 3% auto; border: 1px solid #3B6F9F; border-radius: 0.25em; padding: 30px; background-color: #F1F1F1;">
      <h1 style="padding-bottom: 5px;">Monique Bergevin</h1>
      <h2 style="padding-bottom: 20px;">Content Management System</h2>
      <hr style="color: #66A9D3;">

      <form action="../includes/login.inc.php" method="post">
        <div class="form-group" >
          <label for="txtUid">Username</label>
          <input type="text" class="form-control" id="txtUid" name="txtUid">
        </div>
        <div class="form-group">
          <label for="txtPwd">Password</label>
          <input type="password" class="form-control" id="txtPwd" name="txtPwd">
        </div>
        <div id="errorMessage"></div>
        <button type="submit" class="btn btn-primary" name="login-submit">Login</button>
      </form>
    </div>

    <?php require '../footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>


</html>
