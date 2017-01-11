<?php
  include("./sys/connectdb.php");
  $sql = "SELECT `YEAR` from `event` order by `YEAR` DESC";
  $year = mysqli_fetch_array(mysqli_query($connect, $sql))[0];
  session_start();
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
<script>

       console.log("投票時間外");//不能投票
        $.getJSON( "http://163.18.22.15/voteSystem/group.php?year=<?php echo $year; ?>", function( data ) {
            items=data;
            var i = 0;
            $.each(items,function(){
                //test
                // console.log(items[i]);
               $( ".row" ).append( '<div data-datil-back="'+i+'" id="work'+items[i].G_ID+'" checkdata="'+items[i].G_ID+' "class="work col-md-6"><div id="work-title'+i+'" class="work-title"><a href="#move" id='+i+' key='+i+' class="details"  role="button"><h3 class="h3-text">' +items[i].TITLE + '</h3></a></div><hr> </div>');
                i++;
                i_title=i;

            });
            setTimeout(function () {
                $('html').append("<footer ><div class='footer'><div class='footer-text'><h3 class='footerh3'>製作人:康皓。林典儒</h3></div></div>  </footer>");
            },500);
        });


</script>
<link type="text/css" rel="stylesheet" href="./css/costumer.css">
<script src="./js/costumer.js"></script>
<link type="text/css" rel="stylesheet" href="./css/checkbox.css">
<script type="text/javascript" src="js/jquery.transition.js"></script>


<!-- 康皓寫的 CSS + JS -->
<head>

    <title>-<?php echo Date("Y-m-d"); ?></title>
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
            <li><a href="#" onclick="document.getElementById('id01').style.display='block'">登入</a></li>
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
            <li><a href="admin/admin.html" class="animsition-link">管理員按鈕</a></li>
            <?php
              }
            ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">年份<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="">103</a></li>
                        <li><a href="">104</a></li>
                        <li><a href="">105</a></li>
                    </ul>
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
        <div class="button" id="btniwantvote">
            <a href="#move">我要投票</a>

        </div>
    </div>
<!-- 聽說這是首頁over -->
<!-- 規則 -->

<!-- 規則over -->
<!-- 聽說這是作品集 -->
<form method="post" action="vote.php">
    <div id="move2"></div>

    </div>
<div id="move"></div>
<div id="collections" class="Collections">
            <div class="row collections-row">
            </div>

    <div class="work-wrap">
        <div class="work-container">
            <div class="work-return btn btn-primary" href="#work1040022" > back </div>
            <h2 class="project-title"></h2>
            <div class="project-load">

            </div>
        </div>
    </div>
    </div>

    <br/>
    <div class="comfirmbtn">
<div class="howmanyticket" style="display:none">區塊中的內容</div>
    </div>

</form>

<!-- 聽說這是作品集over -->

<!-- 登入資訊在這傳喔 -->
<div id="id01" class="modal">
    <form class="modal-content animate" action="sys/loginCheck.php" method="post">
        <div class="container">
            <label><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="loginid" required>

            <label><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="loginpasswd" required>

            <input type="hidden" name="loginserver" value="ccms.nkfust.edu.tw"/>
        </div>
        <div class="container" style="background-color:#f1f1f1">
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger">Cancel</button>
            </div>
    </form>
</div>
<!-- 登入資訊在這傳喔over -->

<!-- 影片容器JS專用被隱藏ㄌ -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- 影片容器專用被隱藏over -->

</body>


</html>
