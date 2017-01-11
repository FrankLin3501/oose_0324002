
<?php
$upload_dir = "../../monograph/upload/doc/";

if (!file_exists($upload_dir)) {
	//echo $upload_dir."<br>\n";
	//echo mkdir($upload_dir, 0775, true);
}


//echo "file upload<br>\n";
//==================檔案上傳區塊開始======================
if(empty($_POST['oldfilelink'])){
	$oldfilelink='';
} else {
	$oldfilelink=$_POST['oldfilelink'];
}
//echo $oldfilelink;
// var_dump($_FILES['up_file']);
if (!isset($_FILES['up_file'])) //上傳檔案傳回空白時
{
// echo "none";
 $n_link=$oldfilelink;//舊的檔案仍不變
}
else//有要上傳檔案時，把舊的檔案砍掉
{
	//print_r($_FILES["up_file"]);
 //先檢查是否為合適的RAR或是PDF檔名
 $sub_file_name_RARPDF = substr($_FILES["up_file"]["name"], -4, 4);//抓副檔名英文字<br>
 $sub_file_name_RARPDF = strtolower($sub_file_name_RARPDF);
 $sub_file_name_check  = 0;
if($sub_file_name_RARPDF==".rar" || $sub_file_name_RARPDF==".pdf" || $sub_file_name_RARPDF==".zip")
	$sub_file_name_check = 1;
 //if($sub_file_name_RARPDF !=".pdf" && $sub_file_name_RARPDF !=".rar" && $sub_file_name_RARPDF!=".PDF" && $sub_file_name_RARPDF!=".RAR" && $sub_file_name_RARPDF!=".zip" && $sub_file_name_RARPDF!=".ZIP")
	if($sub_file_name_check == 0 ) {
	 	echo "<p><p><big><b><div align=center><font color=#FF0000><font color=#FF0000>請再次上傳rar檔或是pdf檔案</font></div></b></p></p>";
		//需寫跳回上一頁
		$n_link=$oldfilelink;//舊的檔案仍不變
	} else {
	  $check_file=basename($oldfilelink); //basename --- 傳回不包含路徑的檔案名稱
	  $filename = "/monograph/upload/doc/$check_file";
	  if(is_dir($filename))
	  {//如果是目錄就不做事
	   //echo "dir";
	  }
	  elseif (file_exists($filename)) //確認檔案是否存在
	  {
	    unlink($filename);  //刪除檔案
		//echo "delete complete.";
	  }

  //$ip = $_SERVER["SERVER_ADDR"];//取得網址ip，可參照phpinfo();
//2006/11/24學長原始程式
//  copy($up_file, "./doc/$_FILES["up_file"]["name"]");
//從暫存檔copy到指定目錄 測試if(copy($n_file, "./doc/$n_file_name"))
//
//2006/11/24 new-start
if (!move_uploaded_file($_FILES["up_file"]["tmp_name"], $upload_dir.$_FILES["up_file"]["name"]))
	{
		echo $_FILES["up_file"]["error"]."<p><p><big><b><div align=center><font color=#990000><font color=#990000>傳輸過程發生問題，請重新上傳一次！</font></font></div></b></p></p>";

		die();
	}
	else
	{
	  $up_file=$upload_dir.$_FILES['up_file']['name'];
	  $new_file_name=$upload_dir.$g_id.$sub_file_name_RARPDF;
	  rename($up_file, $new_file_name);// rename("old.txt","new.txt");　　//把old.txt改名為now.txt
	  //echo "rename finished";
	  //$n_link="http://".$ip.$upload_dir.$g_id.$sub_file_name_RARPDF;
	  $n_link="/upload/doc/".$g_id.$sub_file_name_RARPDF;

	  echo "<p><p><big><b><div align=center><font color=#990000><font color=#990000>上傳OK！</font></font></div></b></p></p>";
	}
 }
	$U_SQL="UPDATE `crowd` SET `FILE_LINK` = '$n_link' WHERE `G_ID` = '$g_id'";//進DB修改
	mysqli_query($connect, $U_SQL);
}
//==================檔案上傳區塊結束======================
?>
