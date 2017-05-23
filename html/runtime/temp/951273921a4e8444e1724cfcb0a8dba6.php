<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"/var/www/html/public/../application/index/view/user/index.html";i:1491711911;s:45:"../application/index/view/include/header.html";i:1491711908;s:43:"../application/index/view/include/left.html";i:1491711908;s:45:"../application/index/view/include/footer.html";i:1491711908;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>学生信息</title>
<link rel="stylesheet" type="text/css" href="/public/css/user/index.css">
<link rel="stylesheet" href="/public/css/index/bootstrap.min.css">
<!--<link rel="stylesheet" href="/public/css/index/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="/public/css/index/flat-ui.min.css">
<script src="/public/js/index/jquery-3.1.1.min.js"></script>
<!--<script src="/public/js/index/bootstrap.min.js"></script>-->
<script src="/public/js/index/flat-ui.min.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/user/index.js"></script>
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
			<div class="panel panel-primary">
				<div class="panel-heading">学生信息</div>
  				<table class="table">
					  <tr>
						  <td>学号</td>
						  <td><?php echo $userInfo['uid']; ?></td>
					  </tr>
					  <tr>
						  <td>姓名</td>
						  <td><?php echo $userInfo['uname']; ?></td>
					  </tr>
					  <tr>
						  <td>性别</td>
						  <td>
							  <?php switch($userInfo['sex']): case "0": ?>男<?php break; case "1": ?>女<?php break; endswitch; ?>
						  </td>
					  </tr>
					  <tr>
						  <td>民族</td>
						  <td><?php echo $userInfo['nation']; ?></td>
					  </tr>
					  <tr>
						  <td>政治面貌</td>
						  <td><?php echo $userInfo['political_status']; ?></td>
					  </tr>
					  <tr>
						  <td>生日</td>
						  <td><?php echo $userInfo['birthday']; ?></td>
					  </tr>
					  <tr>
						  <td>身份证</td>
						  <td><?php echo $userInfo['id_card']; ?></td>
					  </tr>
					  <tr>
						  <td>院系</td>
						  <td><?php echo $userInfo['fname']; ?></td>
					  </tr>
					  <tr>
						  <td>入学年</td>
						  <td><?php echo $userInfo['start_school']; ?></td>
					  </tr>
					  <tr>
						  <td>专业</td>
						  <td><?php echo $userInfo['spname']; ?></td>
					  </tr>
					  <tr>
						  <td>修学年限</td>
						  <td><?php echo $userInfo['attend_school_year']; ?></td>
					  </tr>
					  <tr>
						  <td>班级</td>
						  <td><?php echo $userInfo['class']; ?></td>
					  </tr>
					  <tr>
						  <td>年级</td>
						  <td><?php echo $userInfo['grade']; ?></td>
					  </tr>
					  <tr>
						  <td>在校</td>
						  <td><?php echo !empty($userInfo['is_inschool']) && $userInfo['is_inschool']==1?'是':'否'; ?></td>
					  </tr>
					  <tr>
						  <td>考号</td>
						  <td><?php echo $userInfo['test_number']; ?></td>
					  </tr>					  					  
  				</table>
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