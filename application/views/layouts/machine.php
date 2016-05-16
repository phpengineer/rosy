<!DOCTYPE html>
<html lang="zh-CN">
<head>
<title>Gome+ Video System</title>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="stylesheet" href="/resource/css/bootstrap.css" />
<link rel="stylesheet" href="/resource/css/bootstrap.min.css" />
<link rel="stylesheet" href="/resource/css/bootstrap-theme.css" />
<link rel="stylesheet" href="/resource/css/bootstrap-sweetalert.css" />
<link rel="stylesheet" href="/resource/css/bootstrap-datetimepicker.css" />
<link rel="stylesheet" href="/resource/css/bootstrap-daterangepicker.css" />
<link rel="stylesheet" href="/resource/css/bootstrap-select2.css" />
<link rel="stylesheet" href="/resource/css/pnotify.css" />
<link rel="stylesheet" href="/resource/css/jquery-ui.css">
<link rel="stylesheet" href="/resource/css/jquery.Jcrop.css" />
<link rel="stylesheet" href="/resource/css/jquery.fancybox.css" />
<link rel="stylesheet" href="/resource/css/jquery-tagsinput.css" />
<link rel="stylesheet" href="/resource/css/content-style.css" />
<?php $rand = mt_rand();?>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.ui.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.form.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.json.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.fancybox.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.ajaxfileupload.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.Jcrop.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.zclip.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery-tagsinput.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/jquery/moment.js?<?php echo $rand;?>"></script>

<script type="text/javascript" src="/resource/scripts/bootstrap/bootstrap.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/bootstrap/bootstrap-datetimepicker.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/bootstrap/bootstrap-sweetalert.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/bootstrap/bootstrap-daterangepicker.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/bootstrap/bootstrap-select2.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/common.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/swfobject.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/pnotify.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/form.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/md5.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/uploader.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/common/image.js?<?php echo $rand;?>"></script>
<script type="text/javascript" src="/resource/scripts/modules/machine.js?<?php echo $rand;?>"></script>
</head>

<body>
<div class="container-fluid">
  <div class="hide" id="ServerMessageBox"></div>
  <?php echo isset($content) ? $content : ''; ?>
</div>
</body>
</html>
