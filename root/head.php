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
    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- build:css(.) styles/vendor.css -->
    <!-- bower:css -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>bower_components/bootstrap/dist/css/bootstrap.css" />
    <!-- endbower -->
    <!-- endbuild -->
    <!-- build:css(.tmp) styles/main.css -->
    <link rel="stylesheet" href="<?php echo URL_STYLES; ?>global.css">
    <!-- endbuild -->

    <link href="<?php echo SITE_URL; ?>bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>bower_components/bootstrap-social/bootstrap-social.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>bower_components/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?php echo SITE_URL; ?>bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_URL; ?>bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?php echo SITE_URL; ?>bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo SITE_URL; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_URL; ?>bower_components/metisMenu/dist/metisMenu.min.js"></script>
    <script src="<?php echo SITE_URL; ?>/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>

    <script src="<?php echo SITE_URL; ?>bower_components/angular/angular.min.js"></script>
    <script src="<?php echo SITE_URL; ?>bower_components/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js"></script>

    <!-- build:js({app,.tmp}) scripts/main.js -->
    <script src="<?php echo URL_APP; ?>js/main.js"></script>
    <!-- endbuild -->

    <script src="//localhost:35729/livereload.js"></script>
</head>
<body>
<div id="wrapper">
<?php include("left.php"); ?>
    <div id="page-wrapper" style="min-height: 553px;">