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
    
  </head>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#titlePhoto').change(function() {
          var formData = new FormData(),
          // 获取上传文件的File对象
          theFile = $('input[type=file]')[0].files[0];
          // 将上传文件添加到FormData对象中
          formData.append('photo', theFile);
          $.ajax({
            type: 'POST',
            url: 'news/upload.php',
            // contentType必须为false！避免jQuery添加Content-Type头部信息
            contentType: false,
            // processData必须为false！不然jQuery会将formData转换为字符串
            processData: false,
            data: formData,
            dataType: 'text',
            success: function(data) {
                if (data.indexOf('error') >= 0) {
                  alert(data);
                  $('#photoUrl').val('');
                  return;
                }
                alert('上传成功');
                $('#photoUrl').val(data);
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
      <h2>发布新闻</h2>
      <form role="form" id="editForm" action="news/newsSubmit.php" method="post">
        <div class="form-group">
          <br>
          <label>标题：</label><br>
          <input type="text" name="title" class="form-control" id="titleField"><br>
          <label>新闻来源：</label>
          <input type="text" name="src" class="form-control" id="srcField"><br>
          <label>新闻类型：</label>
          <select class="form-control" name="type">
            <option value="0">头条</option>
            <option value="1">财经</option>
            <option value="2">科技</option>
            <option value="3">娱乐</option>
          </select><br>
          <label>新闻详情：</label>
          <textarea name="content" id="contentField" rows="25"></textarea>
          <br> 
          <label for="exampleInputFile">上传新闻标题图片： </label>
          <input type="file" id="titlePhoto" name="photoUrl">
          <p class="help-block">图片上传成功后的URL会显示在以下文本框</p>
          <input type="text" name="photoUrl" class="form-control" id="photoUrl" readonly="readonly">
          <br>
          <button type="button" class="btn btn-danger" style="width: 120px;" onclick="resetText()">重置</button>&nbsp&nbsp&nbsp&nbsp
          <button type="button" class="btn btn-success" style="width: 120px;" onclick="formSubmit()">提交</button>
        </div>
      </form>          
    </div>

    <?php
      include "tools/footer.html";
    ?>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/js/lib/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="dist/js/wangEditor.min.js"></script>
    <script type="text/javascript">
      var editor = new wangEditor('contentField');
      editor.config.uploadImgUrl = "news/upload.php";
      editor.config.uploadImgFileName = "photo";
      editor.create();
      // 提交表单
      function formSubmit(){
        if (($('#titleField').val() == "") || ($('#srcField').val() == "") || ($('#contentField').val() == "") || ($('#photoUrl').val() == "")) {
          alert('信息未填完整');
          return;
        }
        if (confirm("是否确定发布新闻？")) {
          document.getElementById("editForm").submit();
        }
      }
      //重置文本框
      function resetText(){
        if (confirm("是否确定重置？")) {
          document.getElementById("titleField").value="";
          editor.clear();
        }
      }
    </script>
  </body>
  <script type="text/javascript">
      var article = document.getElementById("nav_news");
      article.setAttribute('class','active');
  </script>
</html>