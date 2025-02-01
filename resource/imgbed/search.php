<?php  
  $list = scandir('img/');
  $ae = $_GET['file'];
  $iii = 0;
  foreach ($list as $key => $value) {
    if ($ae == explode(".",$value)[0]) {
        $iii = $value;
    }
  }
  
  if ($iii != 0) {
    echo "<script language = 'javascript' type = 'text/javascript'>";
    echo "window.location.href = 'img/".$iii."'";
    echo "</script>";
  }else {
      echo "未找到文件，请确定文件编号";
  }
?>
