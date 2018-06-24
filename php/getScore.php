<?php
/*$arr = [];
while($row = $result->fetch_assoc()){
  $arr[] = $row;
}
$score = $arr[0]["score"];*/

include_once("connect.php");
$result = $mysqli_monster->query("SELECT * FROM total_score");
$data = $result->fetch_assoc()["score"];

echo $data;


?>
