
<?php
  date_default_timezone_set("Asia/Taipei");

  include("./sys/connectdb.php");
  $sql = "SELECT * FROM `event` order by `YEAR` DESC";
  $event = mysqli_fetch_array(mysqli_query($connect, $sql));
  $year = $event["YEAR"];
  $rule = $event["E_DESC"];
  $limit = $event["E_LIMIT"];

  session_start();

?>
<!--

______            _ _      __            _    _               _                                  _   _     _
|  _  \          ( ) |    / _|          | |  (_)             | |                                | | | |   (_)
| | | |___  _ __ |/| |_  | |_ _   _  ___| | ___ _ __   __ _  | |_ _ __ _   _    __ _ _ __  _   _| |_| |__  _ _ __   __ _
| | | / _ \| '_ \  | __| |  _| | | |/ __| |/ / | '_ \ / _` | | __| '__| | | |  / _` | '_ \| | | | __| '_ \| | '_ \ / _` |
| |/ / (_) | | | | | |_  | | | |_| | (__|   <| | | | | (_| | | |_| |  | |_| | | (_| | | | | |_| | |_| | | | | | | | (_| |
|___/ \___/|_| |_|  \__| |_|  \__,_|\___|_|\_\_|_| |_|\__, |  \__|_|   \__, |  \__,_|_| |_|\__, |\__|_| |_|_|_| |_|\__, |
                                                       __/ |            __/ |               __/ |                   __/ |
                                                      |___/            |___/               |___/                   |___/
 _____                       _   _              _
|_   _|                     | | (_)            | |
  | |   __      ____ _ ___  | |_ _ _ __ ___  __| |
  | |   \ \ /\ / / _` / __| | __| | '__/ _ \/ _` |
 _| |_   \ V  V / (_| \__ \ | |_| | | |  __/ (_| |_ _ _ _
 \___/    \_/\_/ \__,_|___/  \__|_|_|  \___|\__,_(_|_|_|_)


-->
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<!-- CDN jquary  -->

<script src="js/jquery-3.1.1.js"></script>

<!-- 最新編譯和最佳化的 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<!-- 選擇性佈景主題 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
<!-- 最新編譯和最佳化的 JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>


<!-- CDN jquary  -->

<?php

  if (isEvent()) {

  if (isLogin() && inDate() && !isVote()) {
?>
<!-- 康皓寫的 CSS + JS -->

<script>
    $(document).ready(function () {
      var ticketnumber = <?php echo $limit; ?>;//限制投票數上限



      $.getJSON( "http://163.18.22.15/vote/js/group.php", function( data ) {
        items=data;
        var i = 0;
        $.each(items,function(){
          $( ".row" ).append( '<div data-datil-back="'+i+'" id="work'+items[i].G_ID+'" checkdata="'+items[i].G_ID+' "class="work col-md-6"><label>  <div id="work-title'+i+'" class="work-title "><a href="#move" id='+i+' key='+i+' class="details"  role="button"><h3 class="h3-text">' +items[i].TITLE + '</h3></a></div><input id="checkbox'+i+'" type="CHECKBOX" name="group[]" class="checkbox" value="'+items[i].G_ID+'">投我一票</label><hr> </div>');
          i++;
          i_title=i;
        });
        setTimeout(function () {
          $(".comfirmbtn").append('<a href="#" onclick=\'document.getElementById(\"id02\").style.display=\"block\"\'> <button type="submit" class="btn btn-danger btn-lg comfirm">確定投票</button></a>');

          $("html").append("<footer ><div class='footer'><div class='footer-text'><h3 class='footerh3'>製作人:康皓。林典儒</h3></div></div>  </footer>");

          $("#move2").append('<div id="rule" class="rule"> <div class="real-rule"> <h2>投票規則</h2> <?php echo trim(htmlspecialchars($rule)); ?> </div>');
        },1);
      });
    });

</script>
<?php } else { ?>
<script>
$(document).ready(function () {

    $.getJSON( "http://163.18.22.15/vote/js/group.php", function( data ) {
    items=data;
    //console.log(items);
    var i = 0;
    $.each(items, function(){
        //test
        //console.log(items[i]);
       $( ".row" ).append( '<div data-datil-back="'+i+'" id="work'+items[i].G_ID+'" checkdata="'+items[i].G_ID+' "class="work col-md-6"><div id="work-title'+i+'" class="work-title"><a href="#move" id='+i+' key='+i+' class="details"  role="button"><h3 class="h3-text">' +items[i].TITLE + '</h3></a></div><hr> </div>');
        i++;
        i_title=i;

    });

    setTimeout(function () {
        $('html').append("<footer ><div class='footer'><div class='footer-text'><h3 class='footerh3'>製作人:康皓。林典儒</h3></div></div>  </footer>");
    },500);
});
});

</script>
<?php }
  } else { ?>

<script>
  setTimeout(function () {
    $("#move2").append('<div id="rule" class="rule"> <div class="real-rule"> <h2>目前沒有投票。</h2> </div></div>');
  }, 1000);
</script>

  <?php } ?>

<link type="text/css" rel="stylesheet" href="./css/costumer.css">
<link type="text/css" rel="stylesheet" href="./css/checkbox.css">
<script src="./js/costumer.js"></script>
<script type="text/javascript" src="js/jquery.transition.js"></script>


<!-- 康皓寫的 CSS + JS -->
<head>

    <title>
        NKFUST|MIS|VOTE - 實務專題投票系統
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
            <?php
              if (!(@$_SESSION["isLogin_User"]=="yes" || @$_SESSION["isLogin_Admin"]=="yes")) {
            ?>
            <li><a  href="#" onclick="document.getElementById('id01').style.display='block'">登入</a></li>
            <?php
              }
              if (@$_SESSION["isLogin_User"]=="yes" || @$_SESSION["isLogin_Admin"]=="yes") {
            ?>
            <li><a href="sys/logout.php" class="animsition-link">登出</a></li>
            <?php
              }
              if (@$_SESSION["isLogin_User"]=="yes") {
            ?>
            <li><a href="upload/upload.php" class="animsition-link">上傳/修改</a></li>
            <?php
              }
              if (@$_SESSION["isLogin_Admin"]=="yes") {
            ?>
            <li><a href="admin/admin.php" class="animsition-link">管理員按鈕</a></li>
            <?php
              }
              ?>
                <li class="dropdown">
                  <!--
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">年份<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="">103</a></li>

                    </ul>
                  -->
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


<!-- 聽說這是首頁 -->




<div class="fullpage">
        <div class="text">

           <h1><?php echo $year; ?>學年專題投票</h1>
        </div>
        <?php
if (!isLogin() ){
        ?>
        <div class="button" id="btniwantvote">
            <a href="#move" onclick="document.getElementById('id01').style.display='block'">我要投票</a>

        </div>

        <?php }
else{
    ?>
  <div class="button" id="btniwantvote">
      <a href="#move">我要投票</a>
        </div>
  <?php
}
        ?>

<!-- 聽說這是首頁over -->
<!-- 規則 -->

<!-- 規則over -->
<!-- 聽說這是作品集 -->



    </div>
    <div id="move2"></div>
<div id="move"></div>
<div id="collections" class="Collections">
            <div class="row collections-row">
            </div>

    <div class="work-wrap" >
        <div class="work-container">
            <div id="pause-button" class="work-return btn btn-primary" href="#work1040022" > back </div>
            <h2 class="project-title"></h2>
            <div class="project-load">

            </div>
        </div>
    </div>
    </div>

    <br/>
    <div class="comfirmbtn">
      <div class="howmanyticket" style="display:none">區</div>
    </div>



<!-- 聽說這是作品集over -->

<!--  -->
<div id="id01" class="modal">
    <form class="modal-content animate" action="sys/allLoginCheck.php" method="post">
        <div class="form-group cform">
            <label><b>帳號（請使用 nkfust.edu.tw 的帳號登入）</b></label>
            <input class="form-control" type="text" placeholder="Enter Username" name="loginid" required>

            <label><b>密碼</b></label>
            <input class="form-control" type="password" placeholder="Enter Password" name="loginpasswd" required>

            <input type="hidden" name="loginserver" value="ccms.nkfust.edu.tw"/>
        </div>
        <div class="form-group cform" style="background-color:#f1f1f1">
            <button type="submit" class="btn btn-primary">登入</button>
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger">取消</button>
            </div>
    </form>
</div>
<!--  -->

<div id="id02" class="modal">
    <form class="modal-content animate" action="vote.php" method="post">
<div id="id02-text" class="container"></div>
        <div class="container" style="background-color:#f1f1f1">
            <button type="submit" class="btn btn-primary">確定</button>
            <button id="id02-cancel" type="button" onclick="document.getElementById('id02').style.display='none'" class="btn btn-danger">取消</button>
        </div>
        <div  class="id02form"></div>
    </form>
</div>


<!--  -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!--  -->

</body>


</html>


<?php
  function isLogin() {
    if (isset($_SESSION["isLogin_User"])) {
      return true;
    }
    return false;
  }

  function inDate() {
    include('sys/connectdb.php');
    $sql = "SELECT * FROM `event` ORDER BY `YEAR` DESC";
    $event = mysqli_fetch_array(mysqli_query($connect, $sql));

    $today = strtotime(date('Y-m-d'));

    $vote_start = strtotime($event["VOTE_TIME_START"]);
    $vote_end = strtotime($event["VOTE_TIME_END"]);

    if ($vote_start <= $today and $vote_end >= $today) {
      return true;
    }
    return false;
  }

  function inUpDate() {
    include('sys/connectdb.php');
    $sql = "SELECT * FROM `event` ORDER BY `YEAR` DESC";
    $event = mysqli_query($connect, $sql)->fetch_array();

    $today = strtotime(date('Y-m-d'));

    $up_start = strtotime($event["UP_TIME_START"]);
    $up_end = strtotime($event["UP_TIME_END"]);

    if ($up_start <= $today and $up_end >= $today) {
      return true;
    }
    return false;

  }

  function isEvent() {
    include('sys/connectdb.php');
    $sql = "SELECT * FROM `event` ORDER BY `YEAR` DESC";
    $event = mysqli_query($connect, $sql);
    if ($event->num_rows != 0) {
      return true;
    }
    return false;

  }

  function isVote() {
    include('sys/connectdb.php');
    $id = $_SESSION["S_ID"];
    $id = isset($id)?substr($id, 1):$_SESSION["T_ID"];
    //print_r($id);
    $year = @mysqli_query($connect, "SELECT * FROM `event` ORDER BY `YEAR` DESC")->fetch_array()['YEAR'];
    $sql = "SELECT * FROM `vote_check` WHERE `YEAR`=$year AND `ID`='$id'";

    $result = mysqli_query($connect, $sql);
    if ($result->num_rows == 0) {
      return false;
    }
    return true;
  }
?>
