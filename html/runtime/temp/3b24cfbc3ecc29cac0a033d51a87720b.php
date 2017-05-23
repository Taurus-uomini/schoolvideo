<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"/var/www/html/public/../application/index/view/user/question.html";i:1491711912;s:45:"../application/index/view/include/header.html";i:1491711908;s:43:"../application/index/view/include/left.html";i:1491711908;s:45:"../application/index/view/include/footer.html";i:1491711908;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>问题</title>
<link rel="stylesheet" type="text/css" href="/public/css/user/question.css">
<link rel="stylesheet" href="/public/css/index/bootstrap.min.css">
<!--<link rel="stylesheet" href="/public/css/index/bootstrap-theme.min.css">-->
<link rel="stylesheet" href="/public/css/index/flat-ui.min.css">
<script src="/public/js/user/bootstrap/jquery-1.7.2.min.js"></script>
<script src="/public/js/user/bootstrap/bootstrap.min.js"></script>
<!--<script src="/public/js/index/flat-ui.min.js"></script>-->
<script lang="javascript" type="text/javascript" src="/public/js/user/question.js"></script>
<script type="text/javascript"src="/public/js/user/leipi.form.build.core.js"></script>
<script type="text/javascript"src="/public/js/user/leipi.form.build.plugins.js"></script>
</head>
<body onload="load(<?php echo $vid; ?>,<?php echo $cid; ?>);">
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
              <h3 class="panel-title">问题</h3>
          </div>
          <div class="panel-body">
            <button type="button" class="btn btn-primary" id="question_check">确认</button>
            <div class="container">
              <div class="row clearfix">
                <div class="span6">
                  <div class="clearfix">
                    <h3>题目</h3>
                    <hr>
                    <div id="build">
                      <form id="target" class="form-horizontal">
                        <fieldset>
                          <div style="height: 60px;">
                          </div>
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="span6">
                  <h3>拖拽下面的控件到左侧</h3>
                  <hr>
                  <div class="tabbable">
                    <ul class="nav nav-tabs" id="navtab">
                      <li class="active"><a href="#1" data-toggle="tab">单选/复选</a></li>
                      <!--<li class><a id="sourcetab" href="#5" data-toggle="tab">源代码</a></li>-->
                    </ul>
                    <form class="form-horizontal" id="components">
                      <fieldset>
                        <div class="tab-content">
                          <div class="tab-pane active" id="1">
                            <div class="control-group component" rel="popover" title="复选控件" trigger="manual" data-content="<form class='form'><div class='controls'><label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'><label class='control-label'>复选框</label><textarea style='min-height: 200px' id='orgvalue'></textarea><p class='help-block'>一行一个选项</p><hr/><button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button></div></form>">
                              <label class="control-label leipiplugins-orgname">复选框</label>
                              <div class="controls leipiplugins-orgvalue">
                                <label class="checkbox">
                                  <input type="checkbox" name="leipiNewField" title="复选框" value="选项1" class="leipiplugins" leipiplugins="checkbox">
                                  选项1
                                </label>
                                <label class="checkbox">
                                  <input type="checkbox" name="leipiNewField" title="复选框" value="选项2" class="leipiplugins" leipiplugins="checkbox">
                                  选项2
                                </label>
                              </div>
                            </div>
                            <div class="control-group component" rel="popover" title="单选控件" trigger="manual" data-content="<form class='form'><div class='controls'><label class='control-label'>控件名称</label> <input type='text' id='orgname' placeholder='必填项'><label class='control-label'>单选框</label><textarea style='min-height: 200px' id='orgvalue'></textarea><p class='help-block'>一行一个选项</p><hr/><button class='btn btn-info' type='button'>确定</button><button class='btn btn-danger' type='button'>取消</button></div></form>">
                              <label class="control-label leipiplugins-orgname">单选</label>
                              <div class="controls leipiplugins-orgvalue">
                                <label class="radio">
                                  <input type="radio" name="leipiNewField" title="单选框" value="选项1" class="leipiplugins" leipiplugins="radio">
                                  选项1
                                </label>
                                <label class="radio">
                                  <input type="radio" name="leipiNewField" title="单选框" value="选项2" class="leipiplugins" leipiplugins="radio">
                                  选项2
                                </label>
                              </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="5">
                          <textarea id="source" class="span6"></textarea>
                        </div>
                      </div>
                    </fieldset>
                  </form>
                </div>
              </div>
            </div> 
          </div> 
        </div>
      </div>
      <div class="update_wait">
        <img src="/public/img/loging.gif" alt="">
      </div>
		</div>
	</div>
  <div class="modal fade" id="question_set" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="question_setLabel">设置答案</h4>
        </div>
        <div class="modal-body" id="question_div"> 
                            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" id="btn_question_set">确认</button>
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