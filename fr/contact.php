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
    <title>Monique Bergevin - Contact</title>
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
        <li class="nav-item">
          <a class="nav-link" href="./upcoming.php">A venir</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="./contact.php">Contact Us<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../en/contact.php" disabled>English</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="contact-main">
    <div class="container">
      <div class="row">
        <div class="col-4">
          <div id="contactImg"></div>
          <div id="contactInfo" class="project-font project-fontsize-md mt-5">
            <div>Monique Bergevin</div>
            <div>berg5@sympatico.ca</div>
            <div>(613) 240-5666</div>
          </div>
        </div>
        <div class="col-8">
          <form id="contactForm">
            <div class="form-group">
              <label for="txtName">Nom</label>
              <input type="text" class="form-control" name="txtFullName" id="txtName" placeholder="Name" required>
            </div>
            <div class="form-group">
              <label for="txtEmail">Adresse courriel</label>
              <input type="email" class="form-control" name="txtEmail" id="txtEmail" placeholder="name@exemple.com" required>
            </div>
            <div class="form-group">
              <label for="txtSubject">Sujet</label>
              <input type="text" class="form-control" name="txtSubject" id="txtSubject" required>
            </div>
            <div class="form-group">
              <label for="taMessage">Message</label>
              <textarea class="form-control" id="taMessage" name="taMessage" rows="8" cols="80" required></textarea>
            </div>
            <button type="button" id="sendBtn" class="btn btn-primary" name="submit">Envoyer</button>
          </form>
          <div id="emailResult"></div>
        </div>
      </div>
    </div>
  </div>


  <!-- Footer section -->
  <?php require '../footer.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./../js/jquery-3.6.0.min.js"></script>
    <script src="./../js/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="./../js/contact.js"></script> 
  </body>
</html>
