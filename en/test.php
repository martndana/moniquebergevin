<?php

echo 'Opened<br>';

$servername = "db-moniquebergevin.c9wt5b34nzxa.us-east-2.rds.amazonaws.com";
$username = "martndana";
$password = "Fred3381!";
$dbname = "moniquebergevin";

// Database Connection Statement
$link = mysqli_connect($servername, $username, $password, $dbname);
if ($link->connect_errno) {
    printf("Connect failed: %s\n", $link->connect_error);
    exit();
} else {
    echo 'Connected<br>';
}

//$stmt = mysqli_stmt_init($link);
echo 'Link created<br>';

$sql = 'SELECT * FROM paintings';
$dataset=$link->query($sql);
if ($dataset)
{
    echo 'Got dataset<br>';
    var_dump($dataset);
}
else {
    echo 'Didn`t get dataset<br>';
}
