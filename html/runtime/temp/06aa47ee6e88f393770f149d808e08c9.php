<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:63:"/var/www/html/public/../application/index/view/course/show.html";i:1491711908;s:45:"../application/index/view/include/header.html";i:1491711908;s:45:"../application/index/view/include/footer.html";i:1491711908;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>课程视频</title>
<link rel="stylesheet" type="text/css" href="/public/css/course/index.css">
<link rel="stylesheet" href="/public/css/index/bootstrap.min.css">
<!--<link rel="stylesheet" href="/public/css/index/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="/public/css/index/flat-ui.min.css">
<script src="/public/js/index/jquery-3.1.1.min.js"></script>
<!--<script src="/public/js/index/bootstrap.min.js"></script>-->
<script src="/public/js/index/flat-ui.min.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/course/index.js"></script>
</head>
<body onload="load(<?php echo $cid; ?>);">
	<div class="header">
		<nav class="navbar navbar-inverse" role="navigation">
    <ul class="nav navbar-nav">
        <li class="active"><a href="/public/index.php/index/index/index">首页</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
    	<a href="" class="dropdown-toggle" data-toggle="dropdown">
    		魏煜宸
    	    <span class="caret"></span>
        </a>
    	<ul class="dropdown-menu" role="menu">
            <li><a href="/public/index.php/index/user/index">用户中心</a></li>
    		<li><a href="/public/index.php/index/Login/logout">注销</a></li>
    	</ul>
    </li>
</ul>
</nav>
	</div>
	<div class="main">
		<div class=center>
			<div class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object" src="" alt="image">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"></h4>
                    <div class="well">
                        <p></p>
                    </div>        
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">课程视频</h3>
                </div>
                <div class="panel-body">
                    <div  id='video_info' class="row">
                
                    </div>
                </div>
            </div>
            <div class="update_wait">
                <img src="/public/img/loging.gif" alt="">
            </div>
		</div>
	</div>
	<div class="footer">
		<div class="panel panel-default">
  <div class="panel-body">
    <p>版权所有@Taurus-uomin</p>
  </div>
</div>
	</div>
</body>
</html>