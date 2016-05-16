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
<link rel="stylesheet" href="/resource/css/bootstrap-theme.css" />
<link rel="stylesheet" href="/resource/css/content-style.css" />
<link rel="stylesheet" href="/resource/css/jquery.fancybox.css" />

<script type="text/javascript" src="/resource/scripts/jquery/jquery.js"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.form.js"></script>
<script type="text/javascript" src="/resource/scripts/jquery/jquery.fancybox.js"></script>

<script type="text/javascript" src="/resource/scripts/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="/resource/scripts/common/common.js"></script>
<script type="text/javascript" src="/resource/scripts/common/mask.js"></script>
<script type="text/javascript" src="/resource/scripts/common/form.js"></script>
</head>
<body>
<div class="container-fluid">
  <div class="hide" id="ServerMessageBox"></div>
  <?php echo isset($content) ? $content : ''; ?>
</div>
</body>
</html>
