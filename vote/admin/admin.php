<?php
  include("../sys/connectdb.php");
  session_start();

  if (!(isset($_SESSION["isLogin_Admin"]) && strcmp($_SESSION["isLogin_Admin"], "yes")==0)) {
    echo "錯誤，請先登入！";
    header('Refresh: 1; url=../index.php');
    exit();
  } else {

?>

<html>
  <head>
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
    <!--D3JS -->
    <script type="text/javascript" src="//d3js.org/d3.v4.0.0-alpha.35.min.js"></script>
    <!--D3JS  over-->
    <!-- 康皓寫的 CSS + JS -->
    <script src="./js/index.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <!-- 康皓寫的 CSS + JS -->
    <title>NKFUST|MIS|Vote - 管理者介面</title>
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
            <a class="navbar-brand" href="/vote/">NKFUST|MIS|Vote</a>
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

<?php
  $sql = "SELECT * FROM `event` ORDER BY `YEAR` DESC";
  $currentEvent = mysqli_query($connect, $sql);
  if ($currentEvent->num_rows != 0) {
    $currentEvent = $currentEvent->fetch_array();
?>
<div class="one-to-three">
    <div class="one-title">
        <h1>
          最近投票
        </h1>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th>投票學期</th>
                <th>開始上傳日期</th>
                <th>結束上傳日期</th>
                <th>開始投票日期</th>
                <th>結束投票日期</th>
                <th>限制投票數目</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                  <td><?php echo $currentEvent["YEAR"]; ?></td>
                  <td><?php echo $currentEvent["UP_TIME_START"]; ?></td>
                  <td><?php echo $currentEvent["UP_TIME_END"]; ?></td>
                  <td><?php echo $currentEvent["VOTE_TIME_START"]; ?></td>
                  <td><?php echo $currentEvent["VOTE_TIME_END"]; ?></td>
                  <td><?php echo $currentEvent["E_LIMIT"]; ?></td>
                </tr>

            </tbody>
          </table>
    </div>

</div>
<div id="collections" class="Collections">
    <h1>所有組別</h1>
    <?php
    $sql = "SELECT `ticket`.`G_ID`, `TITLE`, `S_VOTE`, `T_VOTE`, `SCORE` FROM `ticket`, `crowd`, `event` WHERE `ticket`.`G_ID`=`crowd`.`G_ID` and `crowd`.`YEAR`=`event`.`YEAR` and `event`.`E_ID`=". $currentEvent["E_ID"];
    $result = mysqli_query($connect, $sql);
    while ($row = $result->fetch_array()) {
    ?>

    <div class="work col-md-4">

        <div class="work-title">
          <h3><?php echo empty($row["TITLE"])?"無資料":$row["TITLE"]; ?></h3>
        </div>
        <div class="work-text">
          學生票數:<?php echo $row["S_VOTE"]; ?>
        </div>
        <div class="work-text">
          老師票數:<?php echo $row["T_VOTE"]; ?>
        </div>
        <div class="work-text">
          分數:<?php echo $row["SCORE"]; ?>
        </div>
    </div>
    <?php } ?>
</div>
<?php
  } else {
?>
<div class="one-to-three"><div class="one-title"><h1>不存在最近一次投票，請新增投票。</h1></div></div>
<?php
  }
?>
</body>
</html>
<?php
  //第一個判斷式
  }
?>
