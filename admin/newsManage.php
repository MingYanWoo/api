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
  	function getNewsType(i) {
  		switch(i){
  			case 0:
  				return '头条';
  			case 1:
  				return '财经';
  			case 2:
  				return '科技';
  			case 3:
  				return '娱乐';
  			default:
  				break;
  		}
  	}
	  $(document).ready(function(){
	    //条件查询按钮
	    $('#searchFormSubmitBtn').click(function(){
	    	var data = {
	    		'id':$('#idField').val(),
	    		'titleKeyword':$('#titleField').val(),
	    		'srcKeyword':$('#srcField').val(),
	    		'newsType':$('#newsType').val(),
	    	}
	    	$.ajax({
	            type: 'POST',
	            url: 'news/getNewsList.php',
	            data: data,
	            dataType: 'text',
	            success: function(result) {
	            	$('#newsList  tr:not(:first)').html('');
	                var str = '';
	                var data = JSON.parse(result);
	                // alert(result);
	                for (i in data) {
	                	str = str+'<tr><td>'+data[i].news_id+'</td><td>'+data[i].title+'</td><td>'+data[i].src+'</td><td>'+getNewsType(data[i].type)+'</td><td>'+data[i].time+'</td><td><button class="btn btn-default btn-xs col-xs-12 col-md-4 col-md-offset-1">修改</button><button class="btn btn-default btn-xs col-xs-12  col-md-4 col-md-offset-2" onclick="deleteNews('+data[i].news_id+')">删除</button></td></tr>';
	                }
	                $('#newsList').append(str);
	           	}
          	});
	    });
	    //进入页面模拟用户点击获取全部数据
	    $('#searchFormSubmitBtn').trigger('click');
	});

	  function deleteNews(index) {
	    	if (confirm("是否确定删除该新闻？")) {
    			$.ajax({
		            type: 'POST',
		            url: 'news/deleteNews.php',
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
      <h2>新闻管理</h2>
      <br>
      <label>查找新闻：</label>
      <form id="searchForm" class="form-inline">
      	<div class="form-group">
    		<label>id：</label>
    		<input type="text" class="form-control" id="idField" name="id">
  		</div>
	  	<div class="form-group">
		    <label>标题关键字：</label>
		    <input type="text" class="form-control" id="titleField" name="titleKeyword">
	  	</div>
	  	<div class="form-group">
		    <label>来源：</label>
		    <input type="text" class="form-control" id="srcField" name="srcKeyword">
	  	</div>
	  	<div class="form-group">
		    <label>类型：</label>
		    <select class="form-control" id="newsType" name="newsType">
		    	<option value="-1">全部</option>
	            <option value="0">头条</option>
	            <option value="1">财经</option>
	            <option value="2">科技</option>
	            <option value="3">娱乐</option>
          </select>
	  	</div>
	  	&nbsp&nbsp
	  	<button type="button" id="searchFormSubmitBtn" class="btn btn-info" style="width: 100px;">查找</button><br>
      </form>
      
      <br>
      <label>新闻列表：</label>
      <table class="table table-bordered" id="newsList">
        <thead>
          <tr>
            <td class="col-xs-1">新闻id</td>
            <td class="col-xs-4">新闻标题</td>
            <td class="col-xs-1">新闻来源</td>
            <td class="col-xs-1">新闻类型</td>
            <td class="col-xs-2">发布时间</td>
            <td class="col-xs-2">操作</td>
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
      var news = document.getElementById("nav_news");
      news.setAttribute('class','active');
  </script>
</html>