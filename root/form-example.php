<?php
    include_once('global.php');
    if ($_SESSION['is_root'] != 1){
        exit;
    }
    include('head.php');
?>
  <div class="panel panel-default">
    <div class="panel-heading">From Example</div>
    <div class="panel-body">
      <form class="form-horizontal" role="form" action="?a=save" method="post" enctype="multipart/form-data">
        <?php
          $f = new formB();
          $f->setColumn(array(2, 8));
          $f->setRequireList(array("username", "password", "email"));
          $f->addInput("text", "username", $tpl->row['username'], "用户名：");
          $f->addHtmlFor("password", '<p class="help-block">Your password must contain 6 characters min. and and 15 characters max.</p>');
          $f->addInput("password", "password", "", "密码：");
          $f->addInput("email", "email", $tpl->row['email'], "邮箱：");
          $f->addRadio("is_disable", $tpl->row['is_disable'], "禁止用户：", array(
            "1" => "Checkbox 1",
            "2" => "Checkbox 2",
            "3" => "Checkbox 3"
          ));
          $f->addRadio("is_disable", $tpl->row['is_disable'], "禁止用户：", array(
            "1" => "Checkbox 1",
            "2" => "Checkbox 2",
            "3" => "Checkbox 3"
          ), "v");
          $f->addInput("text", "last_ip", "127.0.0.1", "上次登陆IP：", "readonly");
          $f->addStaticHtml("127.0.0.1", "上次登陆IP：");
          $f->addCheckbox("is_disable", $tpl->row['is_disable'], "Checkboxes：", array(
            "1" => "Checkbox 1",
            "2" => "Checkbox 2",
            "3" => "Checkbox 3"
          ), "v");
          $f->addCheckbox("is_disable", $tpl->row['is_disable'], "Checkboxes：", array(
            "1" => "Checkbox 1",
            "2" => "Checkbox 2",
            "3" => "Checkbox 3"
          ));
          $f->addSelect("is_disable", $tpl->row['is_disable'], "Checkboxes：", array(
            "1" => "Checkbox 1",
            "2" => "Checkbox 2",
            "3" => "Checkbox 3"
          ));
          $f->addSelect("is_disable", $tpl->row['is_disable'], "Checkboxes：", array(
            "1" => "Checkbox 1",
            "2" => "Checkbox 2",
            "3" => "Checkbox 3"
          ), 1);
          $f->render();
        ?>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" class="btn btn-primary" id="submit" value="Submit" />
          </div>
        </div>
        <input type="hidden" ng-model="form.id">
        <input type="hidden" ng-model="form.page">
      </form>
    </div>
  </div>

<?php include('end.php');?>