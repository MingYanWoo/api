<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">News后台管理</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li id="nav_index"><a href="index.php">系统信息</a></li>
        <li id="nav_news" class="dropdown">
          <a href="##" data-toggle="dropdown" class="dropdown-toggle">新闻<span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li id="nav_news_new"><a href="newNews.php">发布新闻</a></li>
          <li id="nav_news_manage"><a href="newsManage.php">新闻管理</a></li>
          </ul>
        </li>
        
        <li id="nav_comment"><a href="commentManage.php">评论管理</a></li>
        <li id="nav_user"><a href="userManage.php">用户管理</a></li>

        <?php
        session_start();
        if ($_SESSION['loginStatus']['isAdmin']) {
          $string = "<li id=\"nav_manager\" class=\"dropdown\">
          <a href=\"##\" data-toggle=\"dropdown\" class=\"dropdown-toggle\">管理员管理<span class=\"caret\"></span></a>
          <ul class=\"dropdown-menu\">
          <li id=\"nav_manager_new\"><a href=\"newManager.php\">添加管理员</a></li>
          <li id=\"nav_manager_manage\"><a href=\"managerList.php\">管理员列表</a></li>
          </ul>
          </li>";
          echo $string;
        }
        ?>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="##" data-toggle="dropdown" class="dropdown-toggle"><?php session_start();
            echo $_SESSION['loginStatus']['username'];
          ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="tools/logout.php">退出</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>