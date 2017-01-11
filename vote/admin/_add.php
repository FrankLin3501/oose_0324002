<?php
  session_start();

  if (!(isset($_SESSION["isLogin_Admin"]) && strcmp($_SESSION["isLogin_Admin"], "yes")==0)) {
    echo "錯誤，請先登入！";
    header("Refresh: 1; url=../index.php");
  } else {

    if (isset($_POST["Year"]) &&
    isset($_POST["UpTime_S"]) && isset($_POST["UpTime_E"]) &&
    isset($_POST["VoteTime_S"]) && isset($_POST["VoteTime_E"]) &&
    isset($_POST["Limit"]) && isset($_POST["Description"])) {
      $year = $_POST["Year"];
      $uptime_s = $_POST["UpTime_S"];
      $uptime_e = $_POST["UpTime_E"];
      $votetime_s = $_POST["VoteTime_S"];
      $votetime_e = $_POST["VoteTime_E"];
      $limit = $_POST["Limit"];
      $description = $_POST["Description"];

      $hasEvent = checkEvent($year);

      if (!$hasEvent) {
        //echo "add...";
        addEvent($year, $uptime_s, $uptime_e, $votetime_s, $votetime_e, $limit, $description);
      } else {
        echo "錯誤，有重複的年度。";
        header("refresh: 1; url=./admin.php");
      }

    } else {
      echo "有缺少的資料，或是輸入錯誤。";
    }

  }


  function checkEvent($year) {
    include("../sys/connectdb.php");
    $sql = "SELECT `YEAR` FROM `event` WHERE `YEAR`=$year;";
    $result = $connect->query($sql);
    if ($result->num_rows == 0) return false;
    return true;
  }

  function addEvent($year, $uptime_s, $uptime_e, $eltime_s, $eltime_e, $winners, $description) {
    include("../sys/connectdb.php");
    $sql = "INSERT INTO `event` (`E_ID`, `YEAR`, `UP_TIME_START`, `UP_TIME_END`, `VOTE_TIME_START`, `VOTE_TIME_END`, `E_DESC`, `E_LIMIT`) VALUES (NULL, $year, \"$uptime_s\", \"$uptime_e\", \"$eltime_s\", \"$eltime_e\", \"$description\", $winners);";

    if (mysqli_query($connect, $sql)) {
      $sql = "SELECT `E_ID` FROM `event` WHERE `YEAR`=$year;";
      $e_id = mysqli_query($connect, $sql)->fetch_array()['E_ID'];
      //print_r($e_id);
      $sql = "SELECT `G_ID` FROM `crowd` WHERE `YEAR`=$year;";
      $result = mysqli_query($connect, $sql);

      while ($row = $result->fetch_row()) {
        $g_id = $row['G_ID'];
        //print_r($row);
        //echo "<br>";
        $_sql = "INSERT INTO `ticket` (`E_ID`, `G_ID`, `T_VOTE`, `S_VOTE`) VALUES ($e_id, '$g_id', 0, 0);";
        mysqli_query($connect, $_sql);
      }

      echo "新增成功" . "<br>";

    } else {
      echo "新增失敗" . "<br>";

    }
    header("Refresh: 1; url=./votesystem.php");
  }
?>
