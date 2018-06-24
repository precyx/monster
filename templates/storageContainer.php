
<div class="storageContainer">

  <div class="bg">
    <?php
    $storage_rows = 4;
    $storage_columns = 9;
    $number = 1;
      for($i = 0; $i < $storage_rows; $i++){
        echo "<div class='row'>";
        for($j = 0; $j < $storage_columns; $j++){
            echo "<div class='elem' x='".($j+1)."' y='".($i+1)."'>";
            echo "<p class='fruit_name'></p>";
            echo "<p class='username'></p>";
            echo "<div class='inner'>";
            if($i % 2 == 0) echo "<img src='img/empty_mark.png' alt='' />";
            else echo "<img src='img/empty_mark_blue.png' alt='' />";

            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
      }
    ?>
  </div>
  <div class="pickedItem"></div>
</div>
