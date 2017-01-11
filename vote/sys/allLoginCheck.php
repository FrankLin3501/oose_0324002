<?php
  include("connectdb.php");
  session_start();
  if (!isLogin()) {
    //session_destroy();
    if (isset($_POST["loginid"]) && isset($_POST["loginpasswd"]) && isset($_POST["loginserver"])) {
      $userID = $_POST["loginid"];
      $passWD = $_POST["loginpasswd"];
      $loginSV = $_POST["loginserver"];

      if (isAdmin($userID, $passWD)) {
        $_SESSION["ID"] = "admin";
        $_SESSION["id"] = $userID;
        $_SESSION["isLogin_Admin"] = "yes";
        echo "登入成功。";
        //header("Refresh: 1; url=/vote/index.php");
        //exit();
      } else if (isStudent($loginSV, $userID, $passWD)) {
        $_SESSION["isLogin_User"] = "yes";
        if (strpos($userID, "@") !== false) {
          $userID = substr($userID, 0, strpos($userID, "@"));
        }
        $_SESSION["S_ID"] = $userID;
        $_SESSION["ID"] = "student";

        //test other student login
        if (strcmp($_SESSION["S_ID"], "u0324002")==0) {
          // $_SESSION["T_ID"] = "kwsu";
          // $_SESSION["S_ID"] = NULL;
          // $_SESSION["ID"] = "teacher";
        }  else if (strcmp($_SESSION["S_ID"], "u0324084")==0) {
          //$_SESSION["S_ID"] = "u0224021";
        }
        echo "登入成功。";

      } else if (isTeacher($loginSV, $userID, $passWD)) {
        $_SESSION["isLogin_User"] = "yes";
        if (strpos($userID, "@") !== false) {
          $userID = substr($userID, 0, strpos($userID, "@"));
        }
        $_SESSION["T_ID"] = $userID;
        $_SESSION["ID"] = "teacher";
        echo "登入成功。";

      } else {
        echo "錯誤，請重新登入。";
      }

    }
  } else {

    echo "已登入";
  }
  header("Refresh: 1; url=/vote/index.php");

  function isAdmin($AD_ID, $AD_WD) {
    include("connectdb.php");
    $sql = "SELECT * FROM `admin` WHERE `AD_ID`=? AND `AD_PW`=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('ss', $AD_ID, $AD_WD);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    //print_r($result);
    if ($result->num_rows != 0) {
      return true;
    }
    return false;
  }

  function isTeacher($Server, $ID, $PassWD) {
    include("connectdb.php");
    $sql = "SELECT * FROM `faculty_base` WHERE `account`=?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param('s', $ID);
    $stmt->execute();
    $result = mysqli_stmt_get_result($stmt);
    //print_r($result);
    if ($result->num_rows != 0) {
      return CheckPOP3($Server, $ID, $PassWD);
    }
    return false;
  }

  function isStudent($Server, $ID, $PassWD) {
    if (strpos($ID,"u") == 0 && strpos($ID,"24") == 3) {
      return CheckPOP3($Server, $ID, $PassWD);
    }
    return false;
  }

  function CheckPOP3($server,$id,$passwd,$port=110) {
    if (empty($server) || empty($id) || empty($passwd))
      return false;

    @$fs=fsockopen($server,$port,$errno,$errstr,5);
    if (!$fs)
      return false;
    $msg=fgets($fs,128);
    fputs($fs,"user $id\r\n");
    $msg=fgets($fs,128);
    if (strpos($msg,"+OK")===false)
      $if_false=true;
    fputs($fs,"pass $passwd\r\n");
    $msg=fgets($fs,128);
    if (strpos($msg,"+OK")===false)
      $if_false=true;
    fputs($fs,"quit\r\n");
    fclose($fs);
    if (@$if_false)
      return false;

    return true;
  }

  function isLogin() {
    if (isset($_SESSION["isLogin_Admin"]) && strcmp($_SESSION["isLogin_Admin"], "yes")==0) {
      return true;
    } else if (isset($_SESSION["isLogin_User"]) && strcmp($_SESSION["isLogin_User"], "yes")==0) {
      return true;
    } else if (isset($_SESSION["teacher-checkok"]) && strcmp($_SESSION["teacher-checkok"], "yes")==0) {
      return true;
    }
    return false;
  }
?>
