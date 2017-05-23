<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"/var/www/html/public/../application/index/view/user/course.html";i:1491711910;s:45:"../application/index/view/include/header.html";i:1491711908;s:43:"../application/index/view/include/left.html";i:1491711908;s:45:"../application/index/view/include/footer.html";i:1491711908;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>添加课程</title>
<link rel="stylesheet" type="text/css" href="/public/css/user/course.css">
<link rel="stylesheet" href="/public/css/index/bootstrap.min.css">
<!--<link rel="stylesheet" href="/public/css/index/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="/public/css/index/flat-ui.min.css">
<script src="/public/js/index/jquery-3.1.1.min.js"></script>
<!--<script src="/public/js/index/bootstrap.min.js"></script>-->
<script src="/public/js/index/flat-ui.min.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/user/ajaxfileupload.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/user/course.js"></script>
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
			<div class="btn-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcourse">
                    添加课程
                </button>
            </div>
            <div class="modal fade" id="addcourse" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="addcourseLabel">添加课程</h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control" id="course_name" placeholder="课程名称" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btn_addcourse_close" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" id="btn_addcourse">添加</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editcourse" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="editcourseLabel">编辑课程详细信息</h4>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control leftinput" id="edit_course_name" value="" disabled />
                            <img src="" width="100px" id="course_imgsrc" />
    						<input type="file" accept="image/png,image/gif,image/jpeg" name="course_img" id="course_img" />
                            <input type="hidden" id="course_cid" value="" />
                            <input type="hidden" id="course_cdid" value="" />
                            <textarea class="form-control leftinput" rows="3" id="course_introduce" placeholder="详细信息"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="button" class="btn btn-primary" id="btn_editcourse">修改</button>
                        </div>
                    </div>
                </div>
            </div>
            <div  id='course_info' class="row">
                
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