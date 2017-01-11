<?php
  session_start();

  if (!(isset($_SESSION["isLogin_Admin"]) && strcmp($_SESSION["isLogin_Admin"], "yes")==0)) {
    echo "錯誤，請先登入！";
    header("Refresh: 1; url=../index.php");
  } else {

    if (isset($_POST["E_ID"]) && isset($_POST["Year"]) &&
    isset($_POST["UpTime_S"]) && isset($_POST["UpTime_E"]) &&
    isset($_POST["VoteTime_S"]) && isset($_POST["VoteTime_E"]) &&
    isset($_POST["Limit"])) {
      $e_id = $_POST["E_ID"];
      $year = $_POST["Year"];
      $uptime_s = $_POST["UpTime_S"];
      $uptime_e = $_POST["UpTime_E"];
      $votetime_s = $_POST["VoteTime_S"];
      $votetime_e = $_POST["VoteTime_E"];
      $limit = $_POST["Limit"];

      editEvent($e_id, $year, $uptime_s, $uptime_e, $votetime_s, $votetime_e, $limit);
      header("Refresh: 1; url=./votesystem.php");

    } else {
      echo "輸入錯誤";
      header("Refresh: 1; url=./votesystem.php");
    }
  }

  function editEvent($e_id, $year, $uptime_s, $uptime_e, $votetime_s, $votetime_e, $limit) {
    include("../sys/connectdb.php");
    $sql = "UPDATE `event` SET `UP_TIME_START`=?,`UP_TIME_END`=?,`VOTE_TIME_START`=?,`VOTE_TIME_END`=?,`E_LIMIT`=? WHERE `YEAR`=$year AND `E_ID`=$e_id";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssssi", $uptime_s, $uptime_e, $votetime_s, $votetime_e, $limit);

    if ($stmt->execute()) {
      echo "修改成功";
      return true;
    } else {
      echo "修改失敗，請重新確認輸入資料";
      return false;
    }

  }
?>
