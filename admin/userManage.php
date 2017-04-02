<?php
    include "tools/checkLogin.php";
?>

<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News后台管理</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <script type="text/javascript">
	  $(document).ready(function(){
	    //条件查询按钮
	    $('#searchFormSubmitBtn').click(function(){
	    	var data = {
	    		'id':$('#idField').val(),
	    		'usernameKeyword':$('#usernameField').val(),
	    		'nicknameKeyword':$('#nicknameField').val(),
	    		'accountStatus':$('#accountStatus').val(),
	    	}
	    	$.ajax({
	            type: 'POST',
	            url: 'user/getUserList.php',
	            data: data,
	            dataType: 'text',
	            success: function(result) {
	            	$('#userList  tr:not(:first)').html('');
	                var str = '';
	                var data = JSON.parse(result);
	                // alert(result);
	                for (i in data) {
	                	str = str+'<tr><td>'+data[i].user_id+'</td><td>'+data[i].username+'</td><td>'+data[i].nickname+'</td><td>'+(data[i].sex==0 ? '女':'男')+'</td><td>'+data[i].birthday+'</td><td>'+data[i].create_time+'</td><td>'+(data[i].account_status==0 ? '正常':'停用')+'</td><td><button class="btn btn-default col-xs-12 col-md-4 col-md-offset-1">'+(data[i].account_status==0 ? '停用':'恢复')+'</button><button class="btn btn-default col-xs-12  col-md-4 col-md-offset-2" onclick="deleteUser('+data[i].user_id+')">删除</button></td></tr>';
	                }
	                $('#userList').append(str);
	           	}
          	});
	    });
	    //进入页面模拟用户点击获取全部数据
	    $('#searchFormSubmitBtn').trigger('click');
	});

	  function deleteUser(index) {
	    	if (confirm("是否确定删除该用户？")) {
    			$.ajax({
		            type: 'POST',
		            url: 'user/deleteUser.php',
		            data: {'id':index},
		            dataType: 'text',
		            success: function(result) {
		            	$('#searchFormSubmitBtn').trigger('click');
		           	}
          		});
      		}
	    }
  </script>
  <body>
    <?php
      include "tools/navBar.php";
    ?>
    <div class="container">
      <h2>用户管理</h2>
      <br>
      <label>查找用户：</label>
      <form id="searchForm" class="form-inline">
      	<div class="form-group">
    		<label>id：</label>
    		<input type="text" class="form-control" id="idField" name="id">
  		</div>
	  	<div class="form-group">
		    <label>用户名关键字：</label>
		    <input type="text" class="form-control" id="usernameField" name="usernameKeyword">
	  	</div>
	  	<div class="form-group">
		    <label>昵称关键字：</label>
		    <input type="text" class="form-control" id="nicknameField" name="nicknameKeyword">
	  	</div>
	  	<div class="form-group">
		    <label>账号状态：</label>
		    <select class="form-control" id="accountStatus" name="accountStatus">
		    	 <option value="-1">全部</option>
	         <option value="0">正常</option>
	         <option value="1">停用</option>
        </select>
	  	</div>
	  	&nbsp&nbsp
	  	<button type="button" id="searchFormSubmitBtn" class="btn btn-info" style="width: 100px;">查找</button><br>
      </form>
      
      <br>
      <label>用户列表：</label>
      <table class="table table-bordered" id="userList">
        <thead>
          <tr>
            <td class="col-xs-1">用户id</td>
            <td class="col-xs-1">用户名</td>
            <td class="col-xs-2">昵称</td>
            <td class="col-xs-1">性别</td>
            <td class="col-xs-1">生日</td>
            <td class="col-xs-2">创建时间</td>
            <td class="col-xs-1">是否停用</td>
            <td class="col-xs-3">操作</td>
          </tr>
        </thead>       
      </table>
    </div>

    <?php
      include "tools/footer.html";
    ?>
    
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  <script type="text/javascript">
      var user = document.getElementById("nav_user");
      user.setAttribute('class','active');
  </script>
</html>