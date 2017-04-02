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
  </head>
  <script type="text/javascript">
    function jumpTo(index){
      location.href=index+".php";
    }
  </script>
  <body>
    <?php
      include "tools/navBar.php";
    ?>
    <div class="container">


    <?php
      include "tools/footer.html";
    ?>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  <script type="text/javascript">
      var index = document.getElementById("nav_index");
      index.setAttribute('class','active');
  </script>
</html>