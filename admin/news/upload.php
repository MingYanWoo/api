<?php
if ((($_FILES["photo"]["type"] == "image/gif")
|| ($_FILES["photo"]["type"] == "image/jpeg")
|| ($_FILES["photo"]["type"] == "image/pjpeg")
|| ($_FILES["photo"]["type"] == "image/png")
&& ($_FILES["photo"]["size"] < 2000000)))
  {
  if ($_FILES["photo"]["error"] > 0)
    {
    echo "error|服务器端错误";
    }
  else
    {
    if (file_exists("upload/" . $_FILES["photo"]["name"]))
      {
      echo "error|already exists";
      }
    else
      {
      //改成唯一的名字
      $fileName=$_FILES['photo']['name'];//得到上传文件的名字
      $name=explode('.',$fileName);//将文件名以'.'分割得到后缀名,得到一个数组
      $newName = uniqid().'.'.$name[1];
      move_uploaded_file($_FILES["photo"]["tmp_name"],
      "../../img/".$newName);
      echo "http://".$_SERVER['HTTP_HOST']."/api/img/".$newName;
      }
    }
  }
else
  {
  echo "error|图片太大或格式错误";
  }
?>