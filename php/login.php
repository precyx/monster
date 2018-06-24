<?php
include_once("connect.php");

$errors = "";
$successes = "";
$loggedIn = false;

if(!isset($_POST["login-user"]) || $_POST["login-user"] == "") $errors.= wrapText("Username leer.");
if(!isset($_POST["login-pw"]) || $_POST["login-pw"] == "") $errors.= wrapText("Password leer.");

$user = $mysqli_monster->real_escape_string($_POST["login-user"]);
$pw = md5($mysqli_monster->real_escape_string($_POST["login-pw"]));

$user_id = $mysqli_monster->query("SELECT * FROM users WHERE name='".$user."' AND pw='".$pw."';");
if($user_id->num_rows){
  session_start();
  $id = $user_id->fetch_assoc()["id"];
  $successes .= wrapText("ID: ".$id);
  $_SESSION["user"] = $id;
  $loggedIn = true;
}
else{
  $errors = wrapText("Username oder Password falsch.");
}

$successes = "<div class='success'>".$successes."</div>";
$errors = "<div class='error'>".$errors."</div>";

$response = json_encode([
  "loggedIn" => $loggedIn,
  "msg" => $errors.$successes
]);

echo $response;

function wrapText($txt){
  return "<p class='msg'>".$txt."</p>";
}

?>
