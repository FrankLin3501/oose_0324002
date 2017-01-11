<?php
  include("../sys/connectdb.php");
  session_start();
  if (isset($_SESSION["S_ID"])) {
    $identify = $_SESSION["S_ID"];
    if (strpos($identify, "u") == 0) {
      $identify = substr($identify, 1);
    }

  }
  //echo $identify;
  $sql = "SELECT * FROM `student` where `S_ID`='$identify'";
  $result = mysqli_query($connect, $sql);
  $list = mysqli_fetch_array($result);
  //print_r($list);
  $g_id = $list['G_ID'];
  //echo $g_id;
  if (empty($identify)) {
   echo "<p><p><big><b><div align=center><font color=#990000><font color=#000507>尚未登入</font></div></b></p></p>";
   echo "<meta http-equiv=Refresh content=1;url=../index.php>";
 } else if(empty($g_id)) {
    echo "<p><p><big><b><div align=center><font color=#990000><font color=#990000>未新增您的資料或您未正常登入，請連絡 u0324002@mis.nkfust.edu.tw</font></div></b></p></p>";
    //系秘未新增您的資料或您未正常登入，請連絡管理者或系辦
    echo "<meta http-equiv=Refresh content=3;url=../index.php>";
  } else {
    $upload_search_SQL = "SELECT * FROM `crowd` WHERE `G_ID` = '$g_id'";
    $upload_search_datalist = mysqli_query($connect, $upload_search_SQL);
    $upload_search_fielddatas_array = $upload_search_datalist->fetch_array();
?>

<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <head>
    <meta charset="UTF-8">
    <title>修改或上傳</title>
      <script  src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/style.css">
      <script src="js/prefixfree.min.js"></script>
      <script type="text/javascript" src="js/jquery.transition.js"></script>
  </head>

  <body class="">
    <div class="login">
        <h1>上傳</h1>
    <form name="upload" method="post" enctype="multipart/form-data" action="_update.php" class="animsition-link">
        學年度<input type="text" readonly="readonly" value="<?php echo $upload_search_fielddatas_array["YEAR"]; ?>">
        指導老師<input type="text" readonly="readonly" value="<?php echo $upload_search_fielddatas_array["T_NAME"]; ?>">
        檔案確認狀態<input type="text" readonly="readonly" value="<?php
        	  if($upload_search_fielddatas_array["UPLOAD_CHECK"])
        	   echo "已確認成功！";
        	  else
        	   echo "系辦尚未確認";
        	  ?>">
        <font color="red">檔案上傳（文書檔，請使用英文檔名）</font>
        <?php
          if($upload_search_fielddatas_array["FILE_LINK"]==NULL)
    	  		echo "（檔案尚未上傳）";
    		  else
  	  	    echo "<a href=../../monograph".$upload_search_fielddatas_array["FILE_LINK"].">（原始檔案連結）</a>";
    	  ?>
        <input name="up_file" type="file" size="20">

        <font color="red">專題類型</font><?php echo " - " . $upload_search_fielddatas_array["ATTRIBUTE"]; ?><br>
        <?php
          $sql = "SELECT `A_NAME` FROM `attribute`;";
          $attributes = $connect->query($sql);
          $i = 0;
          while ($row = mysqli_fetch_array($attributes)) {
            echo "<label><input name=\"select".($i++)."\" type=\"checkbox\" class=\"checkbox\" value=\"" . $row["A_NAME"] ."\">".$row["A_NAME"]."</label>";
          }
          echo "<label><input name=\"select".($i)."\" type=\"checkbox\" class=\"checkbox\" value=\"\">" . "其他<input style=\"width:auto;\" onchange=\"this.form.select".$i.".value=this.value\" type=\"text\"/></label>";
        ?>
        <br>
        專題學生<input type="text" readonly="readonly" value="<?php
              	  $g_id=$upload_search_fielddatas_array["G_ID"];
              	  $sql_xxx = "SELECT * FROM `student` WHERE `G_ID` = '$g_id'";
              	  $result_xxx = mysqli_query($connect,$sql_xxx);
                  $_tmpStu = "";
              	  while ($fielddatas=mysqli_fetch_array($result_xxx))//輸出欄位資料
                 	  $_tmpStu = $_tmpStu . $fielddatas["S_NAME"] . "、";
                    echo substr($_tmpStu, 0, -3);
                  ?>">
        <font color="red">專題名稱</font><?php
        				if($upload_search_fielddatas_array["UPLOAD_CHECK"]){
        					echo '<input type="hidden" value="' . $upload_search_fielddatas_array["TITLE"] . '">' . $upload_search_fielddatas_array["TITLE"];
        				} else {
        					echo '<input name="P_NAME" type="text" required="required" value="' . $upload_search_fielddatas_array["TITLE"] . '">';
        				}

                ?>
        <font color="red">Youtube影片網址</font><input type="text" name="VIDEO_LINK" pattern="^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$" placeholder="Youtube影片網址" required="required" value="<?php
                echo 'https://www.youtube.com/watch?v='.$upload_search_fielddatas_array["VIDEO_LINK"];
        ?>"/>
        備註(由系辦填寫)<input type="text" readonly="readonly" value="<?php
                echo $upload_search_fielddatas_array["OTHER"];
        ?>">
        <br/>
        <font color="red">摘要(至少需填150字)</font>
        <textarea name="digest" cols="60" rows="15" minlength="150" style="margin: 0px; height: 100px; width: 100%;"><?php echo trim($upload_search_fielddatas_array["ABSTRACT"]); ?></textarea>
        <button type="submit" name="Submit" class="btn btn-primary btn-block btn-large ">上傳</button>
        <input type="hidden" name="g_id" value="<?php echo $g_id ?>">
        <input type="hidden" name="oldfilelink" value="<?php echo $upload_search_fielddatas_array["FILE_LINK"];?>">
    </form>
</div>

  <script src="js/index.js"></script>



  </body>
</html>

<?php
  }
?>
