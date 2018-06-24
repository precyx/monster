<?php
include_once("connect.php");
session_start();

$loggedUser = isset($_SESSION["user"]);
$definedItem = isset($_SESSION["item"]);
$firstCall = isset($_POST["firstCall"]);

if($firstCall){
  showStorageItems($mysqli_monster);
}
else if($loggedUser && $definedItem){
  $item_id = $mysqli_monster->real_escape_string($_SESSION["item"]);
  $x =  $mysqli_monster->real_escape_string($_POST["x"]);
  $y = $mysqli_monster->real_escape_string($_POST["y"]);
  $result = $mysqli_monster->query("SELECT * FROM storage WHERE x=".$x." AND y=".$y.";");
  if(!$result->num_rows){
    $user_id = $_SESSION["user"];
    $result = $mysqli_monster->query('INSERT INTO storage (item_id, user_id, x, y) VALUES ('.$item_id.','.$user_id.",".$x.','.$y.');');
    unset($_SESSION["item"]);
    showStorageItems($mysqli_monster);
  }
  else {echo json_encode("invalid x or y");}
}
else{ echo json_encode('no access'); }

function test(){
  echo json_encode("hallo");
}

function showStorageItems($connection){
  $storage_entries = [];
  $result = $connection->query("SELECT storage.x, storage.y, feed_items.name AS feed_item_name, feed_items.value, feed_items.rarity, feed_items.img, feed_items.color, users.name AS username FROM feed_items, storage, users WHERE feed_items.id = storage.item_id AND users.id = storage.user_id;");
  while($row = $result->fetch_assoc()){
    $storage_entries[] = $row;
  }
  $response = json_encode([
    "storageEntries" => $storage_entries
  ]);
  echo $response;
}









?>
