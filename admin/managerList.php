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
    function getManagerType(i) {
      switch (i) {
        case 0:
          return '否';
        case 1:
          return '是';
        default:
          break;
      }
    }
	  $(document).ready(function(){
	    //条件查询按钮
	    $('#searchFormSubmitBtn').click(function(){
	    	var data = {
	    		'id':$('#idField').val(),
	    		'username':$('#usernameField').val(),
                'isAdmin':$('#managerType').val(),
	    	}
	    	$.ajax({
	            type: 'POST',
	            url: 'manager/getManagerList.php',
	            data: data,
	            dataType: 'text',
	            success: function(result) {
	            	$('#managerList  tr:not(:first)').html('');
	                var str = '';
	                var data = JSON.parse(result);
	                // alert(result);
	                for (i in data) {
	                	str = str+'<tr><td>'+data[i].manager_id+'</td><td>'+data[i].username+'</td><td>'+getManagerType(data[i].is_admin)+'</td><td>'+data[i].time+'</td><td><button class="btn btn-default col-xs-12 col-md-4 col-md-offset-1">修改</button><button class="btn btn-default col-xs-12  col-md-4 col-md-offset-2" id="deleteBtn_'+data[i].id+'" onclick="deleteManager('+data[i].manager_id+')">删除</button></td></tr>';
	                }
	                $('#managerList').append(str);
                  //超级管理员不可删除
                  for (i in data) {
                    if (data[i].is_admin == 1) {
                      $('#deleteBtn_'+data[i].id).attr('disabled', true);
                    }
                  }
	           	}
          	});
	    });
	    //进入页面模拟用户点击获取全部数据
	    $('#searchFormSubmitBtn').trigger('click');
	});

	  function deleteManager(index) {
	    	if (confirm("是否确定删除该管理员？")) {
    			$.ajax({
		            type: 'POST',
		            url: 'manager/deleteManager.php',
		            data: {'id':index},
		            dataType: 'text',
		            success: function(result) {
                  var data = JSON.parse(result);
                  if (data.code == 1) {
                    alert(data.msg);
                    return;
                  }
                  alert(data.msg);
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
      <h2>管理员列表</h2>
      <br>
      <label>查找管理员：</label>
      <form id="searchForm" class="form-inline">
      	<div class="form-group">
    		<label>id：</label>
    		<input type="text" class="form-control" id="idField" name="id">
  		</div>
	  	<div class="form-group">
		    <label>用户名：</label>
		    <input type="text" class="form-control" id="usernameField" name="titleKeyword">
	  	</div>
      <div class="form-group">
        <label>账号类型：</label>
        <select class="form-control" id="managerType" name="isAdmin">
          <option value="-1">全部</option>
          <option value="0">普通账号</option>
          <option value="1">超级管理员</option>
        </select>
      </div>
	  	
	  	&nbsp&nbsp
	  	<button type="button" id="searchFormSubmitBtn" class="btn btn-info" style="width: 100px;">查找</button><br>
      </form>
      
      <br>
      <label>管理员列表：</label>
      <table class="table table-bordered" id="managerList">
        <thead>
          <tr>
            <td class="col-xs-2">管理员id</td>
            <td class="col-xs-3">用户名</td>
            <td class="col-xs-2">是否超级管理员</td>
            <td class="col-xs-2">创建日期</td>
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
      var manager = document.getElementById("nav_manager");
      manager.setAttribute('class','active');
  </script>
</html>