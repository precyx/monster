<?php
  session_start();

  session_destroy();
  unset($_SESSION['user']);
  echo "logged out";
?>
