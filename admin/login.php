<!doctype html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>News后台管理</title>

<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>

<div class="wrapper">

	<div class="container">
		<h1>News后台管理</h1>
		<form class="form" action="tools/checkPwd.php" method="post">
			<input type="text" id="username" name="username" placeholder="用户名">
			<input type="password" id="password" name="password" placeholder="密码">
			<button type="button" id="login-button">登录</button>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
	
</div>

<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="tools/md5.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#login-button').click(function(event){
		$('#password').val(hex_md5($('#password').val()));
		$('form').submit();
//		event.preventDefault();
//		$('form').fadeOut(500);
		$('.wrapper').addClass('form-success');
	});
	$('#password').keydown(function(e){
		if(e.keyCode == 13){
			//模拟点击登陆按钮，触发上面的 Click 事件
			$('#login-button').click();
		}
	});
});
</script>

</body>
</html>