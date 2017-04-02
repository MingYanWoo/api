<?php
   include 'tools/checkLogin.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News后台管理</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dist/css/wangEditor.min.css">
    <script src="//cdn.bootcss.com/jquery/3.1.1/jquery.js"></script>
    <script type="text/javascript" src="tools/md5.js"></script>
    
  </head>
  <script type="text/javascript">
    var canRegister = false;
    $(document).ready(function(){
      $('#username').bind('input propertychange', function() {
          $.ajax({
            type: 'POST',
            url: 'manager/checkUsername.php',
            data: {'username':$('#username').val(),},
            dataType: 'text',
            success: function(result) {
              var data = JSON.parse(result);
              if (data.code == 0) {
                $('#checkUsernameHint').html('该用户名可以使用');
                $('#checkUsernameHint').css('color','green');
                $('#checkUsernameHint').show();
                canRegister = true;
              }else if (data.code == 1) {
                $('#checkUsernameHint').html('该用户名已被使用');
                $('#checkUsernameHint').css('color','red');
                $('#checkUsernameHint').show();
                canRegister = false;
              }else {
                $('#checkUsernameHint').hide();
                canRegister = false;
              }
            }
          });
      });

      $('#surePwd').bind('input propertychange', function() {
        if ($('#password').val() == $('#surePwd').val()) {
          $('#checkPwdHint').hide();
        }else {
          $('#checkPwdHint').show();
        }
      });

      $('#register').click(function(){
        if ($('#username').val() == "") {
          alert('用户名为空！');
          return;
        }
        if (($('#password').val() == "") || ($('#surePwd').val() == "")) {
          alert('密码为空！');
          return;
        }
        if (!canRegister) {
          alert('该用户名已被使用！');
          return;
        }
        if ($('#password').val() != $('#surePwd').val()) {
          alert('两次密码不一致！');
          return;
        }
        $.ajax({
          type: 'POST',
          url: 'manager/addManager.php',
          data: {
            'username':$('#username').val(),
            'password':hex_md5($('#password').val()),
             'isAdmin':$('#managerType').val(),
          },
          dataType: 'text',
          success: function(result) {
              var data = JSON.parse(result);
              if (data.code) {
                alert('添加失败');
                location.href='newManager.php';
              }else {
                alert('添加成功');
                location.href='managerList.php';
              }
          }
        });
      });
    });
  </script>
  <body>
    <?php
      include "tools/navBar.php";
    ?>
    <div class="container">
      <h2>添加管理员</h2><br>
      <form>
        <div class="form-group">
          <label>用户名：</label>
          <input type="text" class="form-control" name="usernameField" id="username">
          <p id="checkUsernameHint" class="help-block" style="color: green; display: none;">该用户名可以使用！</p>
        </div>
        <div class="form-group">
          <label>密码：</label>
          <input type="password" class="form-control" name="pwdField" id="password">
        </div>
        <div class="form-group">
          <label>确认密码：</label>
          <input type="password" class="form-control" name="surePwdField" id="surePwd">
          <p id="checkPwdHint" class="help-block" style="color: red; display: none;">两次密码不一致！</p>
        </div>
        <div class="form-group">
        <label>是否超级管理员：</label>
        <select class="form-control" id="managerType" name="isAdmin">
          <option value="0">否</option>
          <option value="1">是</option>
        </select>
      </div><br>
      <button type="button" id="register" class="btn btn-default btn-success" style="width: 120px;">添加</button>
      </form>
    </div><br>

    <?php
      include "tools/footer.html";
    ?>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
 
    </script>
  </body>
  <script type="text/javascript">
      var manager = document.getElementById("nav_manager");
      manager.setAttribute('class','active');
  </script>
</html>