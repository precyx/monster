<?php

class FeedItem
{
  public $item;

  function __construct() {
    include_once("dbconfig.php");
    $mysqli_monster = new mysqli(DB_SERVER, DB_USER, DB_PASS, DBNAME1);
    $result = $mysqli_monster->query("SELECT * FROM feed_items;");
    $feedItems = [];
    while($row = $result->fetch_assoc()){
      $feedItems[] = $row;
    }
    $this->item = $this->pickRandom($feedItems);
    return $feedItem;
  }

  private function pickRandom($items){
    $pick = $items[rand(0, count($items)-1)];
    if(rand(1, $pick["rarity"]) == 1) return $pick;
    else return $this->pickRandom($items);
  }

}

 ?>
