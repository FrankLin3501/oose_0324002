<?php
  session_start();

  if (!(isset($_SESSION["isLogin_Admin"]) && strcmp($_SESSION["isLogin_Admin"], "yes")==0)) {
    echo "錯誤，請先登入！";
    header("Refresh: 1; url=../index.php");
  } else {

    if (isset($_POST["E_ID"])) {
      $e_id = $_POST["E_ID"];

      deleteEvent($e_id);
      header("Refresh: 1; url=./votesystem.php");

    } else {
      echo "輸入錯誤";
      header("Refresh: 1; url=./votesystem.php");
    }
  }

  function deleteEvent($e_id) {
    include("../sys/connectdb.php");
    $sql0 = "SELECT * FROM `event` WHERE `E_ID`=?";
    $stmt = mysqli_prepare($connect, $sql0);
    $stmt->bind_param("i", $e_id);
    $stmt->execute();
    $year = $stmt->get_result()->fetch_array()["YEAR"];
    $sql = "DELETE FROM `event` WHERE `E_ID`=?;";
    $sql2 = "DELETE FROM `ticket` WHERE `E_ID`=?;";
    $sql3 = "DELETE FROM `vote_check` WHERE `YEAR`=?;";
    $stmt = mysqli_prepare($connect, $sql);
    $stmt->bind_param("i", $e_id);
    $stmt->execute();
    $stmt = mysqli_prepare($connect, $sql2);
    $stmt->bind_param("i", $e_id);
    $stmt->execute();
    $stmt = mysqli_prepare($connect, $sql3);
    $stmt->bind_param("i", $year);

    if ($stmt->execute()) {
      echo "刪除成功";
      return true;
    } else {
      echo "刪除失敗，請重新確認";
      return false;
    }

  }
?>
