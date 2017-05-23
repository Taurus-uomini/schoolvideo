<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/var/www/html/public/../application/index/view/user/course_detail.html";i:1491711910;s:45:"../application/index/view/include/header.html";i:1491711908;s:43:"../application/index/view/include/left.html";i:1491711908;s:45:"../application/index/view/include/footer.html";i:1491711908;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>课程视频</title>
<link rel="stylesheet" type="text/css" href="/public/css/user/course_detail.css">
<link rel="stylesheet" href="/public/css/index/video.css">
<link rel="stylesheet" href="/public/css/index/bootstrap.min.css">
<!--<link rel="stylesheet" href="/public/css/index/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="/public/css/index/flat-ui.min.css">
<script src="/public/js/index/jquery-3.1.1.min.js"></script>
<script src="/public/js/index/jquery.jplayer.min.js"></script>
<!--<script src="/public/js/index/bootstrap.min.js"></script>-->
<script src="/public/js/index/flat-ui.min.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/user/ajaxfileupload.js"></script>
<script lang="javascript" type="text/javascript" src="/public/js/user/course_detail.js"></script>
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
		<div class="left">
			<ul class="nav nav-pills nav-stacked " role="tablist">
	<?php foreach($menu as $m): if($m['show'] == 1): ?>
			<li role="presentation"<?php if($m['active'] == 1): ?>class="active"<?php endif; ?> ><a href="<?php echo $m['url']; ?>"><?php echo $m['name']; ?></a></li>
		<?php endif; endforeach; ?>
</ul>
		</div>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" onclick="click_btn_addvideo();" data-toggle="modal" data-target="#addvideo">
                            添加视频
                        </button>
                    </div>
                    <div class="modal fade" id="addvideo" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="addvideoLabel">添加视频</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="text" class="form-control" id="video_name" placeholder="视频名称" />
                                    <input type="file" accept="audio/mp4, video/mp4" name="course_videofile" id="course_videofile" />
                                    <div id="jp_container_1" class="jp-video jp-video-360p">
		                                <div id="jquery_jplayer_1" class="jp-jplayer"></div>
		                                <div class="jp-gui">
		                                    <div class="jp-interface">
		                                        <div class="jp-controls-holder">
				                                    <a href="javascript:;" class="jp-play" tabindex="1">play</a>
				                                    <a href="javascript:;" class="jp-pause" tabindex="1">pause</a>
				                                    <span class="separator sep-1"></span>
				                                    <div class="jp-progress">
				                                        <div class="jp-seek-bar">
							                                <div class="jp-play-bar"><span></span></div>
						                                </div>
				                                    </div>
				                                    <div class="jp-current-time"></div>
				                                    <span class="time-sep">/</span>
				                                    <div class="jp-duration"></div>
				                                    <span class="separator sep-2"></span>
				                                    <a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a>
				                                    <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a>
				                                    <div class="jp-volume-bar">
				                                        <div class="jp-volume-bar-value"><span class="handle"></span></div>
				                                    </div>
				                                    <span class="separator sep-2"></span>
				                                    <a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a>
				                                    <a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a>
		                                        </div>
		                                    </div>
		                                </div>
		                                <div class="jp-no-solution">
		                                    <span>Update Required</span>
		                                    Here's a message which will appear if the video isn't supported. A Flash alternative can be used here if you fancy it.
		                                </div>
	                                </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">详细介绍</h3>
                                        </div>
                                        <div class="panel-body">
                                            <textarea class="form-control leftinput" rows="3" id="video_introduce" placeholder="详细信息"></textarea>
                                            <input type="hidden" id="cid" value="<?php echo $cid; ?>" />
                                            <input type="hidden" id="vid" value="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="btn_addvideo_close" data-dismiss="modal">取消</button>
                                    <button type="button" class="btn btn-primary" id="btn_addvideo">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
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