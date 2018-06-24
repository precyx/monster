<?php
  include_once("connect.php");
  session_start();
  if(isset($_SESSION["user"])){
    $message = $mysqli_monster->real_escape_string($_POST["message"]);
    $user_id = $mysqli_monster->real_escape_string($_SESSION["user"]);
    $mysqli_monster->query("INSERT INTO messages (user_id, message, created) VALUES ('".$user_id."', '".$message."', '".time()."');");
    echo json_encode([
      "status" => "success"
    ]);
  }
  else{
    echo json_encode([
      "status" => "no access"
    ]);
  }

?>
