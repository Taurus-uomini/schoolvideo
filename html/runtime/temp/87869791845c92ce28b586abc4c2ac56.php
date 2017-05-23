<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"/var/www/html/public/../application/index/view/user/mycourse.html";i:1491711911;s:45:"../application/index/view/include/header.html";i:1491711908;s:43:"../application/index/view/include/left.html";i:1491711908;s:45:"../application/index/view/include/footer.html";i:1491711908;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>我的课程</title>
<link rel="stylesheet" type="text/css" href="/public/css/user/mycourse.css">
<link rel="stylesheet" href="/public/css/index/bootstrap.min.css">
<!--<link rel="stylesheet" href="/public/css/index/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="/public/css/index/flat-ui.min.css">
<script src="/public/js/index/jquery-3.1.1.min.js"></script>
<!--<script src="/public/js/index/bootstrap.min.js"></script>-->
<script src="/public/js/index/flat-ui.min.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/user/mycourse.js"></script>
</head>
<body>
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
		<div class="left">
			<ul class="nav nav-pills nav-stacked " role="tablist">
	<?php foreach($menu as $m): if($m['show'] == 1): ?>
			<li role="presentation"<?php if($m['active'] == 1): ?>class="active"<?php endif; ?> ><a href="<?php echo $m['url']; ?>"><?php echo $m['name']; ?></a></li>
		<?php endif; endforeach; ?>
</ul>
		</div>
		<div class=center>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">我的课程</h3>
                </div>
                <div class="panel-body">
                    <div  id='course_info' class="row">
                
                    </div>
                    <div class="update_wait">
                        <img src="/public/img/loging.gif" alt="">
                    </div>
                </div>
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