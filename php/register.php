<?php
include_once("connect.php");

$errors = "";
$successes = "";
$registered = false;

if(!isset($_POST["register-email"]) || $_POST["register-email"] == "") $errors.= wrapText("E-Mail leer.");
if(!filter_var($_POST["register-email"], FILTER_VALIDATE_EMAIL)) $errors.= wrapText("Keine gültige E-Mail.");
if(!isset($_POST["register-user"]) || $_POST["register-user"] == "") $errors.= wrapText("Username leer.");
if(!isset($_POST["register-pw"]) || $_POST["register-pw"] == "") $errors.= wrapText("Password leer.");

$email = $mysqli_monster->real_escape_string($_POST["register-email"]);
$user = $mysqli_monster->real_escape_string($_POST["register-user"]);
$pw = md5($mysqli_monster->real_escape_string($_POST["register-pw"]));

$findByUsername = $mysqli_monster->query("SELECT 1 FROM users WHERE name ='".$user."';");
if($findByUsername->num_rows){
  $errors .= wrapText("Benuzter vergeben.");
}
$findByEmail = $mysqli_monster->query("SELECT 1 FROM users WHERE email ='".$email."';");
if($findByEmail->num_rows){
  $errors .= wrapText("E-Mail vergeben.");
}

if($errors == ""){
    if($mysqli_monster->query("INSERT INTO users (name, email, pw, created) VALUES ('".$user."','".$email."','".$pw."','".time()."');") === false ){
      echo "SQL error";
      exit;
    }
    else{
      $successes.= wrapText("Registered User: ".$user);
      $registered = true;
      $user_id = $mysqli_monster->query("SELECT id FROM users WHERE name='".$user."' AND pw='".$pw."';");
      $id = $user_id->fetch_assoc()["id"];
      session_start();
      $_SESSION["user"] = $id;
    }
}
$successes = "<div class='success'>".$successes."</div>";
$errors = "<div class='error'>".$errors."</div>";

$return = json_encode([
          "msg" => $errors.$successes,
          "registered" => $registered
        ]);
echo $return;

function wrapText($txt){
  return "<p class='msg'>".$txt."</p>";
}

//header('Location: http://php.kikoweb.ch/monster');

?>
