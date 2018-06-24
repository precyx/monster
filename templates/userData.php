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

<div class="logout_wrap form_wrap">
  <div class="button topbar_button login animate" data-inkcolor="#5af06d">
    <?php echo $row["name"]; ?>
  </div>
  <div class="login container" action="php/login.php" method="post">
    <h1><?php echo $row["name"] . " (".$row["id"].")"; ?></h1>
    <h1><?php echo $row["email"]; ?></h1>
    <h1><?php echo $row["score"]; ?></h1>
    <h2></h2>
    <input class="button submit" type="button" name="name" value="Logout">
  </div>
</div>
