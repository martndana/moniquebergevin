<?php

if (isset($_POST['login-submit'])) {

  include './dbh.inc.php';

  $uid = htmlentities($_POST['txtUid']);
  $pwd = htmlentities($_POST['txtPwd']);

  if (empty($uid) || empty($pwd)) {
    header("Location: ../cms/login.php?error=emptyfields");
    exit();
  } else {
    $sql = "SELECT * FROM users WHERE uidUsers=?;";

    $stmt = mysqli_stmt_init($link);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../cms/login.php?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $uid);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);

      if ($row = mysqli_fetch_assoc($result)) {
        if (!md5($pwd) == $row['pwdUsers']) {
          header("Location: ../cms/login.php?error=incorrectpassword");
          exit();
        } else if (md5($pwd) == $row['pwdUsers']) {
          session_start();
          $_SESSION['userID'] = $row['idUsers'];
          $_SESSION['userUID'] = $row['uidUsers'];
          header("Location: ../cms/index.php?login=success");
          exit();
        } else {
          header("Location: ../cms/login.php?error=_" . $pwdCheck . "_incorrectpassword");
          exit();
        }
      } else {
        header("Location: ../cms/login.php?error=nouser");
        exit();

      }
    }
  }

} else {
  header("Location: ../cms/login.php?test=redirect");
  exit();
}
