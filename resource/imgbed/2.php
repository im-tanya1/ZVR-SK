<?php
    include '../../common.php';
    
    $url = $_POST["url"];
    // 创建连接
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // 检测连接
    if (!$conn) {
        unlink($url);
        mysqli_close($conn);
        die('{
            "code": "500" 
        }');
    }
     
    $sql = "INSERT INTO ImageBed (url, autherId, reg_date)
    VALUES ('".$url."', '".$_POST["uid"]."', now())";

    
    if ($conn->query($sql) === FALSE) {
        unlink($url);
        mysqli_close($conn);
        die('{
            "code": "500"
        }');
    }else{
        echo '{
            "code": "200"
        }';
    }
    mysqli_close($conn);
?>