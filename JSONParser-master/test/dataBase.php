<?php
  function connect(){
    $mysqli = new mysqli("localhost","root","","eddb");
    if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }
    return $mysqli;
  }
  function insertQuery($query){
    $mysqliObj = connect();
    $answer = $mysqliObj->query($query);
    if($answer) echo "insert succed";
  }
  function createQuery($obj){
    $string = "INSERT INTO stations_listings (`id`,`station_id`,`commodity_id`,`supply`,`buy_price`,`sell_price`,`demand`,`collected_at`) VALUES('";
    foreach($obj as $value){
      $string.=$value."','";
    }
    $string = substr($string, 0, -2);
    $string.=")";
    insertQuery($string);
    echo $string;
    echo "<br>";

  }
  

?>