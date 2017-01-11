<meta charset="utf-8"/>
<?php
  require("./sys/connectdb.php");
  session_start();
  /*
  #error code
  401 - no login
  402 - wrong identity

  405 - wrong POST
  411 - user in the group
  412 -
  */

  if (isset($_SESSION["isLogin_User"]) && (strcmp($_SESSION["isLogin_User"], "yes") == 0)) {
    $id = $_SESSION["ID"];

    if (strcmp($id, "student") == 0) {
        $param = "`S_VOTE`=`S_VOTE`+1, `score`=`score`+1";
        $id = substr($_SESSION["S_ID"], 1);
        $g_id = getGroupByID($id);

    } else if (strcmp($id, "teacher") == 0) {
        $param = "`T_VOTE`=`T_VOTE`+1, `score`=`score`+4";
        $id = $_SESSION["T_ID"];
        $g_id = getGroupByTID($id);//find teacher group id

    } else {
      hasError(402);
    }
  } else {
    hasError(401);
  }

  if (isset($_POST["group"])) {
    $group = $_POST["group"];
    $group = array_unique($group);
    //print_r($group);
  } else {
    hasError(405);
  }

  if (isset($_POST["gLength"])) {
    $length = $_POST["gLength"];
  } else {
    hasError(405);
  }


  $sql = "SELECT * FROM `event` WHERE CURDATE() BETWEEN `VOTE_TIME_START` AND `VOTE_TIME_END`;";//CURDATE()
  $currentEvent = mysqli_query($connect, $sql);
  //print_r($currentEvent);
  if ($currentEvent->num_rows != 0) {
    $currentEvent = $currentEvent->fetch_array();
    $year = $currentEvent["YEAR"];
    $limit = $currentEvent["E_LIMIT"];

  } else {
    hasError(403);
  }

  if (is_array($g_id)) {
    foreach ($g_id as $_g_id) {
      if (in_array($_g_id, $group)) {
        hasError(411);
      }
    }
  } else {
    if (in_array($g_id, $group)) {
      hasError(411);
    }
  }

  if ($length > $limit) {
    hasError(405);

  }

  $sql = "SELECT * FROM `vote_check` WHERE `ID`=$id";
  $check = mysqli_query($connect, $sql);
  if ($check->num_rows == 0) {
    foreach ($group as $g_id) {
      $sql = "UPDATE `ticket` SET $param WHERE `ticket`.`G_ID`=$g_id;";
      //echo $sql . "\n";
      mysqli_query($connect, $sql);
    }

    $sql = "INSERT INTO `vote_check` (`YEAR`, `ID`) VALUES ($year, '$id');";
    //echo $year;
    mysqli_query($connect, $sql);
  } else {
    hasError(412);
  }



  function getGroupByID($id) {
    include("./sys/connectdb.php");
    $sql = "SELECT `G_ID` FROM `student` WHERE `S_ID` LIKE '$id';";
    $result = mysqli_query($connect, $sql);
    //print_r($result);
    if ($result->num_rows == 0) {
      return -1;
    }
    return $result->fetch_array()["G_ID"];
  }

  function getGroupByTID($id) {
    include("./sys/connectdb.php");
    $sql = "SELECT `YEAR` FROM `event` ORDER BY `YEAR` DESC";
    $year = @mysqli_fetch_array(@mysqli_query($connect, $sql))['YEAR'];
    $sql = "SELECT `G_ID`, `YEAR`, `account` FROM `crowd`, `faculty_base` WHERE `faculty_base`.`account`='$id' AND `faculty_base`.`c_name`=`crowd`.`T_NAME` AND `YEAR`=$year ORDER BY `YEAR` DESC;";
    $result = mysqli_query($connect, $sql);
    $g_id = [];
    while ($row = $result->fetch_array()) {
      $g_id[] = $row["G_ID"];
    }
    return $g_id;
  }


  function hasError($code) {
    switch($code) {
      case 405:
        echo "輸入有誤，請重新確認。";break;
      case 401:
        echo "錯誤，請先登入後再投票。";break;
      case 402:
        echo "錯誤，並非本系統的成員，如有任何問題請洽系統維護。";break;
      case 403:
        echo "錯誤，現在不在投票時間。";break;
      case 411:
        echo "錯誤，選取的組別包含自己。";break;
      case 412:
        echo "錯誤，已經投過票。";break;
    }

    header("Refresh: 1; url=./index.php");
    exit();
    //header("Refresh: 1;Location: ./index.php");
  }

  echo "投票成功";
  header("Refresh: 1; url=./index.php");
  exit();
?>
