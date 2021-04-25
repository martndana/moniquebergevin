<?php
  include '../includes/dbh.inc.php';  //database connection

  $sql = 'SELECT `id`, `description`, `description_fr`, `status` FROM `upcoming` WHERE `status` = 1'; //SQL Statement

  $result = null; //SQL result placeholder
  $stmt = mysqli_stmt_init($link);  //Initialize SQL statement

  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
  }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/icons/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="../images/icons/favicon.ico" type="image/x-icon">
    <title>Monique Bergevin - A venir</title>
  </head>
  <body class="project-font">

    <!-- Navigation Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light project-fontsize-md nav-border">
  <a class="navbar-brand" href="#"><img src="../images/logos/logo.png" alt="Monique Logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="./index.php">Acceuil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./bio.php">Démarche artistique & Biographie</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="./portfolio.php" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Galerie
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./portfolio.php">Tout</a>
          <a class="dropdown-item" href="./portfolio.php?filter=1">Disponible</a>
          <a class="dropdown-item" href="./portfolio.php?filter=0">Non-disponible</a>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="./upcoming.php">A venir<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./contact.php">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../en/upcoming.php" disabled>English</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container project-font mt-5 mb-5">
  <h2>ACTIVITÉS A VENIR</h2>

  <ul>
    <?php
      $outputList = '';
      if (!isset($result)) {
        echo 'SQL statement not prepared.';
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
          if ($row["status"]) {
            $outputList .= '<li>' . $row['description_fr'] . '</li>';  //Add Each Item to the List
          }
        }
        echo $outputList; //Display the list
      }
    ?>
  </ul>

</div>
<!-- Footer section -->
<?php require '../footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="../js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
