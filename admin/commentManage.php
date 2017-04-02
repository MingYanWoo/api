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
	    		'commentKeyword':$('#commentField').val(),
	    		'nicknameKeyword':$('#nicknameField').val(),
	    		'newsTitleKeyword':$('#newsTitleField').val(),
	    	}
	    	$.ajax({
	            type: 'POST',
	            url: 'comment/getCommentList.php',
	            data: data,
	            dataType: 'text',
	            success: function(result) {
	            	$('#commentList  tr:not(:first)').html('');
	                var str = '';
	                var data = JSON.parse(result);
	                // alert(result);
	                for (i in data) {
	                	str = str+'<tr><td>'+data[i].comment_id+'</td><td>'+data[i].detail+'</td><td>'+data[i].comment_time+'</td><td>'+data[i].user_id+'</td><td>'+data[i].nickname+'</td><td>'+data[i].news_id+'</td><td>'+data[i].title+'</td><td><button class="btn btn-default col-xs-12" onclick="deleteComment('+data[i].comment_id+')">删除</button></td></tr>';
	                }
	                $('#commentList').append(str);
	           	}
          	});
	    });
	    //进入页面模拟用户点击获取全部数据
	    $('#searchFormSubmitBtn').trigger('click');
	});

	  function deleteComment(index) {
	    	if (confirm("是否确定删除该评论？")) {
    			$.ajax({
		            type: 'POST',
		            url: 'comment/deleteComment.php',
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
      <h2>评论管理</h2>
      <br>
      <label>查找评论：</label>
      <form id="searchForm" class="form-inline">
      	<div class="form-group">
    		<label>id：</label>
    		<input type="text" class="form-control" id="idField" name="id">
  		</div>
	  	<div class="form-group">
		    <label>评论关键字：</label>
		    <input type="text" class="form-control" id="commentField" name="usernameKeyword">
	  	</div>
	  	<div class="form-group">
		    <label>昵称关键字：</label>
		    <input type="text" class="form-control" id="nicknameField" name="nicknameKeyword">
	  	</div>
      <div class="form-group">
        <label>新闻关键字：</label>
        <input type="text" class="form-control" id="newsTitleField" name="nicknameKeyword">
      </div>
	  	<button type="button" id="searchFormSubmitBtn" class="btn btn-info" style="width: 100px;">查找</button><br>
      </form>
      
      <br>
      <label>用户列表：</label>
      <table class="table table-bordered" id="commentList">
        <thead>
          <tr>
            <td class="col-xs-1">评论id</td>
            <td class="col-xs-4">内容</td>
            <td class="col-xs-1">评论时间</td>
            <td class="col-xs-1">用户id</td>
            <td class="col-xs-1">昵称</td>
            <td class="col-xs-1">新闻id</td>
            <td class="col-xs-2">新闻标题</td>
            <td class="col-xs-1">操作</td>
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
      var comment = document.getElementById("nav_comment");
      comment.setAttribute('class','active');
  </script>
</html>