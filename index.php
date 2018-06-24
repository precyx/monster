<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/jquery.custom-scrollbar.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script src="js/jquery.animateNumber.js"></script>
        <script src="js/jquery.custom-scrollbar.js"></script>
        <script src="js/script.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="img/fav.ico" type="image/x-icon" />
    </head>
    <body>
      <div class="main">
        <div class="users default-skin">
          <div class="header_bar">
            <h1>User List</h1>
            <input id="showEmail" type="checkbox" name="showEmail" value="showEmail">
          </div>
        <?php
          include_once("php/connect.php");
          session_start();
          $allUsers = $mysqli_monster->query("SELECT * FROM users ORDER BY score DESC, created DESC");
          $i = 0;

          echo "<div class='wrap header'>";
          echo wrapText("", "index");
          echo wrapText("ID:", "id");
          echo wrapText("User:", "user");
          echo wrapText("E-Mail:", "email");
          echo wrapText("Next Reset:", "nextReset");
          echo wrapText("FCount:", "feedCount");
          echo wrapText("Score:", "score");
          echo "<br>";
          echo "</div>";

          while($row = $allUsers->fetch_assoc()){
            $classes = "";
            if(isset($_SESSION["user"]) && $_SESSION["user"] == $row["id"]) $classes =" activeUser";
            else $classes ="";
            echo "<div class='wrap".$classes."'>";
            echo wrapText(++$i.": ", "index");
            echo wrapText($row["id"], "id");
            echo wrapText($row["name"], "user");
            echo wrapText($row["email"], "email");
            $nextReset = round(($row["latest_feed_item_generated"]+24*60*60 - time())/60/60, 1);
            if($nextReset>0) echo wrapText($nextReset."h", "nextReset");
            else echo wrapText("Active", "nextReset");
            echo wrapText($row["feed_count"], "feedCount");
            echo wrapScore($row["score"], $row["score"], "score");
            echo "<br>";
            echo "</div>";
          }
          function wrapText($txt, $classes){
            return "<p class='".$classes."'>".$txt."</p>";
          }
          function wrapScore($txt, $score, $classes){
            if($score > 500) return "<p class='".$classes." p p500'>".$txt."</p>";
            else if($score > 10) return "<p class='".$classes." p p10'>".$txt."</p>";
            else {return "<p class='".$classes."'>".$txt."</p>";}
          }
        ?>
      </div>

        <div class="buttonbar user">
          <?php
          session_start();
            if(isset($_SESSION["user"])) {
              include_once("templates/userDataView.php");
            }
            else{
              include_once("templates/registerView.php");
              include_once("templates/loginView.php");
            }
          ?>
        </div><!-- end topbar -->


        <div class="feedItemOverlay">
          <div class="supercenter">
            <div class="box">
                <div class="img">
                  <img src="/monster/img/dragonfruit.png" alt="" />
                </div>
<h2 class="title">Dragonfruit</h2>
                <div class="text">
                  <p class="value"><span class="label">Value: </span><span class="val">1500</span></p>
                  <p class="rarity"><span class="label">Rarity: </span><span class="val">10</span></p>
                </div>

                <div class="buttons">
                  <div class="button store">
                    Store
                  </div>
                  <div class="button destroy">
                    destroy
                  </div>
                  <div class="button feed">
                    feed
                  </div>
                </div>
            </div>


          </div>
        </div>

        <?php
          include_once("templates/storageContainer.php");
         ?>

        <div class="barwrap">
          <h1>
            <span class="score"></span>
            <span class="txt"> Points</span>
          </h1>
          <div class="bar">
            <div class="fill">

            </div>
          </div>
        </div>

        <div class="centerWrap">
          <div class="sun">
            <?php echo file_get_contents("./img/sun.svg", true); ?>
          </div>
          <div class="spider">
            <?php echo file_get_contents("./img/ice_spider_purple.svg", true); ?>
          </div>

          <div class="title">
          </div>
          <div class="button pick animate">
              Pick.
          </div>
        </div>





        <div class="portal">
            <img src="./img/portal.png" alt="" width="500px" />
        </div>

        <div class="chatContainer">
          <div class="chat">
            <div class="notifications"></div>
            <h2>Long Polling Chat</h2>
            <div class="messages">
            </div>
            <div class="userinput">
              <input class="message" type="text" name="chatMessage" placeholder="message...">
              <input class="sendButton" type="button" name="chatSend" value="Send">
            </div>
          </div>
        </div>



        <div class="fruits">
          <div class="bg">
          <div class="melon fruit">
            <?php echo file_get_contents("./img/melon.svg", true); ?>
            <p>Melon</p>
          </div>
          </div>

          <div class="cherry fruit">
            <?php echo file_get_contents("./img/cherry.svg", true); ?>
            <p>Cherry</p>
          </div>

          <div class="passionfruit fruit">
            <?php echo file_get_contents("./img/passionfruit.svg", true); ?>
            <p>Passionfruit</p>
          </div>
          <div class="passionfruit_orange fruit">
            <?php echo file_get_contents("./img/passionfruit_orange.svg", true); ?>
            <p>Passionfruit Orange</p>
          </div>
          <div class="sweet_granadilla fruit">
            <?php echo file_get_contents("./img/sweet_granadilla.svg.svg", true); ?>
            <p>Sweet Granadilla</p>
          </div>

          <div class="starfruit fruit">
            <?php echo file_get_contents("./img/starfruit.svg", true); ?>
            <p>starfruit</p>
          </div>

          <div class="dragonfruit fruit">
            <?php echo file_get_contents("./img/dragonfruit.svg", true); ?>
            <p>dragonfruit</p>
          </div>
          <div class="banana fruit">
            <?php echo file_get_contents("./img/banana.svg", true); ?>
            <p>Banana</p>
          </div>
          <div class="orange fruit">
            <?php echo file_get_contents("./img/orange.svg", true); ?>
            <p>Orange</p>
          </div>
          <div class="lemon fruit">
            <?php echo file_get_contents("./img/lemon.svg", true); ?>
            <p>Lemon</p>
          </div>
          <div class="blueberry fruit">
            <?php echo file_get_contents("./img/blueberry.svg", true); ?>
            <p>blueberry</p>
          </div>
          <div class="kiwi fruit">
            <?php echo file_get_contents("./img/kiwi.svg", true); ?>
            <p>Kiwi</p>
          </div>
          <div class="golden_kiwi fruit">
            <?php echo file_get_contents("./img/golden_kiwi.svg", true); ?>
            <p>Golden Kiwi</p>
          </div>
          <div class="strawberry fruit">
            <?php echo file_get_contents("./img/strawberry.svg", true); ?>
            <p>strawberry</p>
          </div>
          <div class="raspberry fruit">
            <?php echo file_get_contents("./img/raspberry.svg", true); ?>
            <p>raspberry</p>
          </div>
          <div class="coconut fruit">
            <?php echo file_get_contents("./img/coconut.svg", true); ?>
            <p>coconut</p>
          </div>
          <div class="currant fruit">
            <?php echo file_get_contents("./img/currant.svg", true); ?>
            <p>currant</p>
          </div>
          <div class="black_currant fruit">
            <?php echo file_get_contents("./img/black_currant.svg", true); ?>
            <p>black currant</p>
          </div>
        </div>


        <div class="aliens" style="display:none;">
        <div class="alien alienE1">
          <?php echo file_get_contents("./img/alien_e1.svg", true); ?>
        </div>
        <div class="alien alienE2">
          <?php echo file_get_contents("./img/alien_e2.svg", true); ?>
        </div>
        <div class="alien alienE3">
          <?php echo file_get_contents("./img/alien_e3.svg", true); ?>
        </div>
        <div class="alien alienE4">
          <?php echo file_get_contents("./img/alien_e4.svg", true); ?>
        </div>

        </div>
      </div>
    </body>
</html>
