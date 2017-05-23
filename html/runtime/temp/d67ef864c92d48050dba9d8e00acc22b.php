<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"/var/www/html/public/../application/index/view/login/login.html";i:1491711909;}*/ ?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>登陆</title>
  <link rel="stylesheet" href="/public/css/login/style.css">
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="/public/js/login/index.js"></script>
</head>
<body>
  <div id="login">
  <form>
    <h1>登陆</h1>
    <input type="text" placeholder="学号" id="uid">
    <input type="password" placeholder="密码" id="password">
    <input id="yzm" type="text" placeholder="验证码"><img id="imgyzm" src="" />
    <input type="hidden" id="imgsrc" value="" />
    <button type="button" id="btn_dl">登陆</button>
  </form>
  <div class="login_wait">
    <img src="/public/img/loging.gif" alt="">
  </div>
</div>
</body>
</html>
