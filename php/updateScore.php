<?php
include_once("connect.php");
include_once("generateFeedItem.php");
session_start();
if(isset($_SESSION["user"])){
  $result = $mysqli_monster->query("SELECT latest_feed_item_generated FROM users WHERE id ='".$_SESSION["user"]."';");
  $latestFeed = $result->fetch_assoc()["latest_feed_item_generated"];
  if($result->num_rows){
    if(time() > $latestFeed + 24*60*60 || $_SESSION["user"] == 1){
      $randomFeedItem = (new FeedItem())->item;
      $_SESSION["item"] = $randomFeedItem["id"];
      $result = $mysqli_monster->query("SELECT score FROM total_score");
      $oldScore = $result->fetch_assoc()["score"];
      $newScore = $oldScore + $randomFeedItem["value"];
      $mysqli_monster->query("UPDATE total_score SET score=".$newScore.", changed =".time().";");
      $mysqli_monster->query("UPDATE users SET latest_feed_item_generated=".time().", score=score+".$randomFeedItem["value"].", feed_count=feed_count+1 WHERE id=".$_SESSION["user"].";");
      $response = json_encode([
        newScore => $newScore,
        feedItem => $randomFeedItem
      ]);
      echo $response;
    }
  }
}
else echo "";

?>
