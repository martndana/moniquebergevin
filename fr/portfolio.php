<?php
  include '../includes/dbh.inc.php';

  $categoryTitle ='';
  $allLinkClass = 'btn-cursor ';
  $availableLinkClass = 'btn-cursor ';
  $notAvailableLinkClass = 'btn-cursor ';

  $filter = 0;

  // Saves filter value from GET to local variable
  if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
  }

  switch ($filter) {
    case 1: {
      $categoryTitle = 'Oeuvres disponibles';
      $availableLinkClass .= 'currentList';
      break;
    }
    case 2: {
      $categoryTitle = 'Oeuves non-disponibles';
      $notAvailableLinkClass .= 'currentList';
      break;
    }
    default: {
      $categoryTitle = 'Toutes les oeuvres';
      $allLinkClass = 'currentList';
      $filter = 0;
    }
  }

  $sql = 'SELECT `id`, `name`, `dimensions`, `medium_fr`, `location`, `status` FROM `paintings`';

  if ($filter > 0) {
    $sql .= ' WHERE `status` = ' . $filter;
  }

  $sql .=  ' ORDER BY `name`';

  $result = null;
  $stmt = mysqli_stmt_init($link);

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
    <script type="text/javascript" src="../js/main.js"></script>
    <title>Monique Bergevin - Portfolio</title>
  </head>
  <body>

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
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="./portfolio.php" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Galerie
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="./portfolio.php">Tout</a>
              <a class="dropdown-item" href="./portfolio.php?filter=1">Disponible</a>
              <a class="dropdown-item" href="./portfolio.php?filter=2">Non-disponible</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./upcoming.php">A venir</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../en/portfolio.php" disabled>English</a>
          </li>
        </ul>
      </div>
    </nav>

  <div class="container-fluid mt-5 mb-5 project-font">
    <div class="row">
      <div class="col-2">
        <h3><a id="AllLink" class="btn-cursor <?php echo $allLinkClass ?>" href="./portfolio.php">Galerie</a></h3>
        <div class="mt-3">
          <!-- <div> <a id="AllLink" class="btn-cursor <?php echo $allLinkClass ?>" href="./portfolio.php">Toutes les peintures</a></div> -->
          <div> <a id="availableLink" class="btn-cursor <?php echo $availableLinkClass ?>" href="./portfolio.php?filter=1">Oeuvres disponibles</a></div>
          <div> <a id="notAvailableLink"class="btn-cursor <?php echo $notAvailableLinkClass ?>" href="./portfolio.php?filter=2">Oeuvres non-disponibles</a></div>
        </div>
      </div>
      <div class="col-10">
        <h2 id="categoryTitle" class="project-font">
          <?php echo $categoryTitle ?>
        </h2>
        <br>
        <div id="gallery" class="justify-content-around">
          <?php
          if (!isset($result)) {
            echo 'SQL statement not prepared.';
          } else {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<script> addToArray(' . json_encode($row) . ')</script>';
            }
            echo '<script> populateGallery() </script>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal" class="modal-background full">
    <span id="modalClose" class="modal-btn" onclick="modalClose()">&times;</span>
    <img id="modalImage" src="" alt="" />
    <div class="modal-details">
      <h4 id="modalTitle"></h4>
      <div id="modalDimensions" class="project-fontsize-md project-font"></div>
      <div id="modalMedium" class="project-fontsize-md project-font"></div>
    </div>
    <span id="previous" class="modal-btn" onclick="previousImage()"></span>
    <span id="next" class="modal-btn" onclick="nextImage()"></span>
  </div>


    <!-- Footer section -->
    <?php require '../footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
