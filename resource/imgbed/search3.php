<?php  
  $list = scandir('head/');
  $ae = $_GET['file'];
  $iii = 0;
  foreach ($list as $key => $value) {
    if ($ae == explode(".",$value)[0]) {
        $iii = $value;
    }
  }
  
  if ($iii != 0) {
    echo file_get_contents("img/".$iii);
  }else {
      echo "未找到文件，请确定文件编号";
  }
?>
