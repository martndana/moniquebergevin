<?php

$activeGallery = ($_SESSION['currentPage']=="gallery")?"active":"";
$activeUpcoming = ($_SESSION['currentPage']=="upcoming")?"active":"";

echo '
<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-light bg-light project-fontsize-md nav-border">
<a class="navbar-brand" href="#"><img src="../images/logos/logo.png" alt="Monique Logo"></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavDropdown">
<ul class="navbar-nav">
  <li class="nav-item ' . $activeGallery . '">
    <a class="nav-link" href="./index.php">Gallery</a>
  </li>
  <li class="nav-item ' . $activeUpcoming . '">
    <a class="nav-link" href="./upcoming_cms.php">Upcoming</a>
  </li>
</ul>
</div>
</nav>'

?>
