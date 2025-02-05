<?php
    die("该接口暂时停用");

    $files = $_FILES['file'];
    $iii = 0;
    $list = scandir('./img/');
    
    foreach ($list as $key => $value) {
        if (explode(".",$list[$key]) > $iii) {
            $iii = $iii + 1;
        }
    }
    $name = $iii.".".array_pop(explode(".",$files['name']));

    $upload_path = "img/"; 
    if(move_uploaded_file($files['tmp_name'],$upload_path.$name)){
      echo '{
          "code": "200",
          "msg": "null",
          "number": "'. $iii .'",
          "searchUrl": "/resource/imgbed/search2.php?file='. $iii .'",
          "url": "/resource/imgbed/img/'. $name .'"
      }';
    }else{
      echo '{
          "code": "500",
          "msg": "上传失败"
      }';
    }
?>