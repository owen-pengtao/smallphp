<?php
include('../config.php');
include('controller.php');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理</title>
    <meta http-equiv="content-Type" content="text/html;charset=utf-8" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="content-language" content="zh-cn" />
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>bower_components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo URL_STYLES; ?>global.css">
</head>
<body>
<div id="wrapper">
<div id="spLoginForm" class="container-fluid">
    <div class="login-panel panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">登录后台管理</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="login.php?a=login" method="post" onsubmit="return check()">
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">用户名：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" autofocus="" required="" maxlength="20" tabindex="1"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">密　码：</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required="" maxlength="32" tabindex="2" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="vcode" class="col-sm-2 control-label">验证码：</label>
                    <div class="col-sm-7">
                        <input name='vcode' class="form-control" id="vcode" type='text' required="" maxlength="4" tabindex="3">
                    </div>
                    <div class="col-sm-3">
                        <img src="imgchk.php" class="vcode" align='absmiddle' border='0' width="100" height="34"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('end.php');?>