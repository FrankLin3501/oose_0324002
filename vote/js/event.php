<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: *");
  include("../sys/connectdb.php");

  $myArray = array();

  $sql = "SELECT `YEAR`, `UP_TIME_START`, `UP_TIME_END`, `VOTE_TIME_START`, `VOTE_TIME_END`, `E_LIMIT` FROM `event` ORDER BY `YEAR` DESC;";
  $result = mysqli_query($connect, $sql);
  //print_r($result);
  if ($result) {

      $row = $result->fetch_array(MYSQLI_ASSOC);
      while($row != null) {

          $myArray[] = $row;

          $row = $result->fetch_array(MYSQLI_ASSOC);

        }
        echo json_encode($myArray, JSON_UNESCAPED_UNICODE);

    }

?>
