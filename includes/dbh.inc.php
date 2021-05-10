<?php

// Database Connection Parameters
$servername = "db-moniquebergevin.c9wt5b34nzxa.us-east-2.rds.amazonaws.com";
$username = "martndana";
$password = "Fred3381!";
$dbname = "moniquebergevin";

// Database Connection Statement
$link = mysqli_connect($servername, $username, $password, $dbname);
if ($link->connect_errno) {
  printf("Connect failed: %s\n", $link->connect_error);
  exit();
}
