<?php
  include_once("../sys/connectdb.php");
  session_start();

  if (!(isset($_SESSION["isLogin_Admin"]) && strcmp($_SESSION["isLogin_Admin"], "yes")==0)) {
    echo "錯誤，請先登入！";
  } else {

?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<!-- CDN jquary  -->
<script  src="https://code.jquery.com/jquery-3.1.1.js"   integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="   crossorigin="anonymous"></script>
<!-- 最新編譯和最佳化的 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<!-- 選擇性佈景主題 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<!-- 最新編譯和最佳化的 JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<!-- CDN jquary  -->

<!-- 康皓寫的 CSS + JS -->
<script src="./js/index.js"></script>
<link rel="stylesheet" href="css/index.css">
<!-- 康皓寫的 CSS + JS -->
<head>
  <title>
    NKFUST|MIS|VOTE - 新增投票
  </title>
</head>

<body>



<nav class="navbar navbar-default navbar-fixed-top ">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed " data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/vote/index.php">NKFUST|MIS|Vote</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../sys/logout.php" class="animsition-link">登出</a></li>
                <li><a href="./admin.php" class="animsition-link">管理員按鈕(儀錶板)</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">功能列<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="./votesystem.php">新增/結束投票</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="one-to-three">
    <h1 class="addNewVote">新增投票</h1>
    <div class="addNewVote">
        <form action="_add.php" method="post">
            投票學期:
            <input name="Year" type="text" placeholder="EX:105" required="required" />
            開始上傳日期:
            <input name="UpTime_S" type="date" required="required">
            結束上傳日期:
            <input  name="UpTime_E" type="date" required="required">
            開始投票日期:
            <input name="VoteTime_S" type="date" required="required">
            結束投票日期:
            <input name="VoteTime_E" type="date" required="required">
            限制投票數目:
            <input name="Limit" type="text" onkeyup="value=value.replace(/[^\d]/g,'');" required="required">
            <br>
            投票詳細規則:
            <br>
            <textarea name="Description" placeholder="" required="required" style="height:260px; width: 80%;"></textarea>
           <br>
            <input type="submit" class="btn btn-primary" value="提交">
        </form>
        <!--<h1 style="color: #670d10">選擇結束將會把投票強制結束</h1>-->
    </div>
    <div id="collections" class="Collections">

        <table class="table">
            <thead>
            <tr>
                <th>投票學期</th>
                <th>開始上傳日期</th>
                <th>結束上傳日期</th>
                <th>開始投票日期</th>
                <th>結束投票日期</th>
                <th>限制投票數目</th>
                <th>票數 學生 || 教授</th>
                <th>功能</th>
            </tr>
            </thead>
            <tbody>
              <?php

              $resultNow = mysqli_query($connect, "SELECT * FROM `event` WHERE CURDATE() <= `VOTE_TIME_END` ORDER BY `YEAR` DESC");
              $resultOutDate = mysqli_query($connect, "SELECT * FROM `event` WHERE CURDATE() > `VOTE_TIME_END` ORDER BY `YEAR` DESC");

                if (($resultNow->num_rows + $resultOutDate->num_rows) != 0) {
                  $result = $resultNow;
                  while ($row = $result->fetch_array()) {
                    $event_id = $row["E_ID"];
                    $year = $row["YEAR"];
                    $uptime_s = $row["UP_TIME_START"];
                    $uptime_e = $row["UP_TIME_END"];
                    $votetime_s = $row["VOTE_TIME_START"];
                    $votetime_e = $row["VOTE_TIME_END"];
                    $description = $row["E_DESC"];
                    $limit = $row["E_LIMIT"];

                    $vote_inform = mysqli_query($connect, "SELECT `E_ID`, SUM(`T_VOTE`) AS Teacher, SUM(`S_VOTE`) AS Student FROM `ticket` where `E_ID`=$event_id;")->fetch_array();
                    $ticketStu = $vote_inform["Student"];
                    $ticketTea = $vote_inform["Teacher"];

              ?>


              <tr>
                <form action="#" method="post">
                  <input type="hidden" name="E_ID" value="<?php echo $event_id; ?>"/>
                <td> <input type="text" name="Year" value="<?php echo $year; ?>" readonly required="required" size="2"/></td>
                <td> <input type="date" name="UpTime_S" value="<?php echo $uptime_s; ?>" required="required" size="5"/></td>
                <td> <input type="date" name="UpTime_E" value="<?php echo $uptime_e; ?>" required="required" size="18"/></td>
                <td> <input type="date" name="VoteTime_S" value="<?php echo $votetime_s; ?>" required="required" size="18"/></td>
                <td> <input type="date" name="VoteTime_E" value="<?php echo $votetime_e; ?>" required="required" size="2"/></td>
                <td> <input type="text" name="Limit" value="<?php echo $limit; ?>" required="required" size="2"/></td>
                <td><?php echo $ticketStu . " || ". $ticketTea; ?></td>
                <td>
                  <button class="btn btn-primary" onclick="this.form.action='_edit.php';">修改</button>
                  <!--<button class="btn btn-danger">結束</button>-->
                  <button class="btn btn-danger" onclick="this.form.action='_delete.php';">刪除</button>
                </td>
                </form>
              </tr>


              <?php
                  }
                  $result = $resultOutDate;
                  while ($row = $result->fetch_array()) {
                    $event_id = $row["E_ID"];
                    $year = $row["YEAR"];
                    $uptime_s = $row["UP_TIME_START"];
                    $uptime_e = $row["UP_TIME_END"];
                    $votetime_s = $row["VOTE_TIME_START"];
                    $votetime_e = $row["VOTE_TIME_END"];
                    $description = $row["E_DESC"];
                    $limit = $row["E_LIMIT"];

                    $vote_inform = mysqli_query($connect, "SELECT `E_ID`, SUM(`T_VOTE`) AS Teacher, SUM(`S_VOTE`) AS Student FROM `ticket` where `E_ID`=$event_id;")->fetch_array();
                    $ticketStu = $vote_inform["Student"];
                    $ticketTea = $vote_inform["Teacher"];

              ?>


              <tr>
                <form action="#" method="post"><input type="hidden" name="E_ID" value="<?php echo $event_id; ?>"/>

                <td><?php echo $year; ?></td>
                <td><?php echo $uptime_s; ?></td>
                <td><?php echo $uptime_e; ?></td>
                <td><?php echo $votetime_s; ?></td>
                <td><?php echo $votetime_e; ?></td>
                <td><?php echo $limit; ?></td>
                <td><?php echo $ticketStu . " || ". $ticketTea; ?></td>
                <td>
                  <button class="btn btn-danger" onclick="this.form.action='_delete.php';">刪除</button>
                </td>
              </form>
              </tr>


              <?php
                  }
                } else {
                  echo "<tr>目前無投票</tr>";
                }
              ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<?php
  }
?>
