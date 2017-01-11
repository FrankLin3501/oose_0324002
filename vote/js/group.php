<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    include("../sys/connectdb.php");
    $myArray = array();
    // if (isset($_GET["year"]))
    //     $year=$_GET["year"];
    // else
    //     $year=date('Y')-1911;
    // $year=is_numeric($year)?$year:(date('Y')-1911);
    $sql = "SELECT `YEAR` FROM `event` ORDER BY `YEAR` DESC;";
    $result = mysqli_query($connect, $sql);
    if ($result->num_rows != 0) {
      $year = $result->fetch_array()["YEAR"];

      if ($result = mysqli_query($connect, "SELECT `crowd`.`G_ID`, `TITLE`, `ATTRIBUTE`, `ABSTRACT`, `VIDEO_LINK` FROM `crowd` WHERE YEAR=$year ;")) {
          $row = $result->fetch_array(MYSQLI_ASSOC);
          while($row != null) {
              $G_ID = $row['G_ID'];
              $r_tmp = mysqli_query($connect, "SELECT `S_ID`, `S_NAME` FROM `student` where `G_ID` = $G_ID;");
              while ($row_tmp = $r_tmp->fetch_array(MYSQLI_ASSOC)) {
                  $S_ID = $row_tmp['S_ID'];
                  unset($row_tmp['S_ID']);
                  $row['STUDENT'][$S_ID] = $row_tmp;
              }
              //$row['STUDENT'] = ;
              if ($row['TITLE'] != NULL)
                $myArray[] = $row;

              $row = $result->fetch_array(MYSQLI_ASSOC);
              // print_r($row);
              // echo "<br>\n";
          }
          echo json_encode($myArray, JSON_UNESCAPED_UNICODE);

      }
    }
?>
