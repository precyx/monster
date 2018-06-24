<?php
  include_once("connect.php");
  $polling = $_POST["polling"];

  if($polling){
    $result = $mysqli_monster->query("SELECT created FROM messages ORDER BY created DESC LIMIT 1");
    $updated_timestamp = $result->fetch_assoc()["created"];
    $client_timestamp = $_POST["timestamp"];

    while($updated_timestamp <= $client_timestamp){
      if($client_timestamp == 0) {break;}
      sleep(0.5);
      clearstatcache();
      $result = $mysqli_monster->query("SELECT created FROM messages ORDER BY created DESC LIMIT 1");
      $updated_timestamp = $result->fetch_assoc()["created"];
    }

    $client_timestamp = time();
  }

  $result = $mysqli_monster->query(
  "SELECT messages.message, users.name, users.color
  FROM messages, users
  WHERE messages.user_id=users.id
  ORDER BY messages.created
  DESC LIMIT 15;");
  $messages = [];
  while($row = $result->fetch_assoc()){
    $row["message"] = htmlspecialchars($row["message"]);
    $messages[] = $row;
  }
  $messages = array_reverse($messages);
  echo json_encode([
      "messages" => $messages,
      "updated_timestamp" => $updated_timestamp,
      "client_timestamp" => $client_timestamp,
      "polling" => $polling
    ]);
?>
