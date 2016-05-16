<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gome+ Video System</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/resource/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/resource/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/resource/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/resource/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/resource/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="/resource/scripts/bootstrap/html5shiv.js"></script>
        <script src="/resource/scripts/bootstrap/respond.min.js"></script>
        <script type="text/javascript" src="/resource/scripts/modules/login.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/"><b>Gome+ </b>Video System</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg"></p>
        <form action="<?php echo URL::site('author/login'); ?>" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" id="name" name="name" placeholder="用户名" required autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" id="password" name="password" placeholder="密码" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
              <p></p>
            </div>
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    
	<div class="text-center" style="font-size: 11px;color: #367fa9; font-family: Arial;">&copy; 2016 Gome+ VideoTeam </div>
  	<div class="text-center" style="font-size: 12px;color: #367fa9;">* 请使用Firefox, Chrome, IE9+浏览器达到更好效果</div>
    
    <!-- jQuery 2.1.4 -->
    <script src="/resource/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="/resource/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="/resource/plugins/iCheck/icheck.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
 </body>
</html>