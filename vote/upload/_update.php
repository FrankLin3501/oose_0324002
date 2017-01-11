<?php
  include_once("../sys/connectdb.php");
  session_start();
  //secho isset($_FILES["up_files"]) ."<hr>";
  if (isset($_SESSION["S_ID"])) {
    $identify = $_SESSION["S_ID"];
    if (strpos($identify, "u") == 0) {
      $identify = substr($identify, 1);
    }
  }
  //echo $identify;
  $sql = "SELECT * FROM `student` WHERE `S_ID`='$identify'";
  $result = mysqli_query($connect, $sql);
  $list = mysqli_fetch_array($result);
  $g_id = $list['G_ID'];
//==================專題類別顯示開始==================
  $att_SQL = "SELECT `A_NAME` from `attribute`"; //針對部份做處理
  $att_datalist=mysqli_query($connect,$att_SQL);
  $att_fieldnum=mysqli_num_fields($att_datalist); //有幾個欄位
  $y=0;
  while($att_fielddatas=mysqli_fetch_array($att_datalist))//輸出欄位資料
  {
   for ($x=0;$x<$att_fieldnum;$x++)//輸出欄位資料
   {
    $att_result[$y]=$att_fielddatas[$x];
    $y++;
   }
  }
  $att_count=4;//count($att_result);//count計算年度陣列共有多大\

  if (empty($identify))  {
    echo "<p><p><big><b><div align=center><font color=#990000><font color=#000507>尚未登入</font></div></b></p></p>";
    echo "<meta http-equiv=Refresh content=1;url=../index.php>";
  } else if(empty($g_id))  {
    echo "<p><p><big><b><div align=center><font color=#990000><font color=#990000>未新增您的資料或您未正常登入，請連絡 u0324002@mis.nkfust.edu.tw</font></div></b></p></p>";
    echo "<meta http-equiv=Refresh content=3;url=../index.php>";
  }  else  {
    $find_g_id="SELECT `G_ID`,`S_NAME` from `student` where `S_ID`='$identify'";
    $find_g_id_query = mysqli_query($connect, $find_g_id);
    $find_g_id_query_array = mysqli_fetch_array($find_g_id_query);
    $g_id = $find_g_id_query_array["G_ID"];
    $check = 0;
    for($counter_select = 0;$counter_select < $att_count ; $counter_select++)
    {
      if(isset($_POST["select".$counter_select]))
        $check = 1;
    }

    //這判斷是否有選擇類別，如果有就更新資料
    if($check == 1) {
    //  if(isset($att_other_text) && isset(${"select".$att_count}))
    //    ${"select".$att_count}=$att_other_text;
     $att='';
     for ( $i=0; $i<=$att_count; $i++ ) {

      if(isset($_POST["select" . $i])){
        $att = $att . $_POST["select" . $i] . "　";
        //echo $_POST["select" . $i] . "<br>";
      }
     }

     if (isset($_POST['P_NAME']) && $p_name = $_POST['P_NAME']) {
       $p_name = "'".$p_name."'";
     } else {
       $p_name = "`TITLE`";
     }

     if ($digest = htmlspecialchars($_POST['digest'])) {
       $digest = "'".$digest."'";
     } else {
       $digest = "`ABSTRACT`";
     }

     if ($video_link = parse_yturl($_POST['VIDEO_LINK'])) {
       $video_link = "'".$video_link."'";
     } else {
       $video_link = "`VIDEO_LINK`";
     }
     $att = trim($att, '　');
     $u_sql_2="UPDATE `crowd` SET `TITLE`=$p_name, `ABSTRACT`=$digest, `ATTRIBUTE`='$att', `VIDEO_LINK`=$video_link WHERE G_ID='$g_id';";
      //echo $u_sql_2;
      mysqli_query($connect, $u_sql_2);
    }

    if (isset($_FILES["up_file"])) {
      include "./file_process.php";
    }
    //header("Location: upload.php");
  }
  header("Refresh: 1; url=../index.php");
function parse_yturl($url)
{
    $pattern = '#^(?:https?://|//)?(?:www\.|m\.)?(?:youtu\.be/|youtube\.com/(?:embed/|v/|watch\?v=|watch\?.+&v=))([\w-]{11})(?![\w-])#';
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}
?>
