<?php
include_once("php/connect.php");
session_start();
$id = "";
if(isset($_SESSION["user"])) {
  $id = $_SESSION["user"];
}
$data = $mysqli_monster->query("SELECT * FROM users WHERE id='".$id."';");
$row = $data->fetch_assoc();

?>

<div class="logout container" action="php/login.php" method="post">
  <h1><?php echo $row["name"]; ?></h1>
  <h2></h2>
  <div class="line">
    <label for="login-user">Username</label>
    <input class="text" type="text" name="name" id="login-user">
  </div>
  <div class="line">
    <label for="login-pw">Password</label>
    <input class="text" type="password" name="name" id="login-pw">
  </div>
    <input class="button submit" type="button" name="name" value="Logout">
</div>
