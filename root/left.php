<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.php">后台管理系统</a>
  </div>
  <!-- /.navbar-header -->

  <ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
        </li>
        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
        </li>
        <li class="divider"></li>
        <li><a href="login.php?a=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
      </ul>
      <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
  </ul>
  <!-- /.navbar-top-links -->

  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <li><a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
        <li>
          <a href="#"><i class="fa fa-wrench fa-fw"></i> 内容管理<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="cache.php">缓存管理</a></li>
            <li><a href="category.php">分类管理</a></li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="fa fa-wrench fa-fw"></i> 用户管理<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="user.php?a=index">用户管理</a></li>
            <li><a href="user.php?a=add">添加用户</a></li>
          </ul>
        </li>
        <li>
          <a href="#"><i class="fa fa-wrench fa-fw"></i> 管理权限设置<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse">
            <li><a href="admin.php">管理员管理</a></li>
            <li><a href="admin.php?a=add">添加管理员</a></li>
          </ul>
        </li>
        <li class="active">
          <a href="#"><i class="fa fa-files-o fa-fw"></i> 其他<span class="fa arrow"></span></a>
          <ul class="nav nav-second-level collapse in">
            <li><a href="index.php?">接口列表</a></li>
            <li><a href="form-example.php">Form 例子</a></li>
            <li><a href="dberror.php">数据库错误</a></li>
            <li><a href="phpinfo.php">phpinfo()</a></li>
            <li><a href="http://localhost/phpmyadmin/" target="_target">phpMyadmin</a></li>
            <li><a href="login.php?a=logout">退出系统</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- /.sidebar-collapse -->
  </div>
  <!-- /.navbar-static-side -->
</nav>
