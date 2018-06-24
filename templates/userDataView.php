<?php
include_once("php/connect.php");
session_start();
$id = "";
if(isset($_SESSION["user"])) {
  $id = $_SESSION["user"];
}
$data = $mysqli_monster->query("SELECT * FROM users WHERE id='".$id."';");
$row = $data->fetch_assoc();

$nextReset = round(($row["latest_feed_item_generated"]+24*60*60 - time())/60/60, 1);

?>

<div class="logout_wrap form_wrap">
  <div class="button topbar_button login animate" data-inkcolor="#5af06d">
    <?php echo $row["name"]; ?>
  </div>
  <div class="logout container" action="php/login.php" method="post">
    <h1><?php echo $row["name"] . " (".$row["id"].")"; ?></h1>
    <h1><?php echo $row["email"]; ?></h1>
    <h1><?php echo "Score: "; echo $row["score"]; ?></h1>
    <h1><?php echo "Next Reset: "; echo $nextReset."h" ?></h1>
    <h2></h2>
    <input class="button submit" type="button" name="name" value="Logout">
  </div>
</div>
