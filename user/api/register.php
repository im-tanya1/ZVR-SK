<?php
    include '../../common.php';
     
    $canvas = $_GET["canvas"];
    $name = $_GET["name"];
    $passwords = $_GET["password"];
    $method = $_GET["method"];
    $ip = $_SERVER["REMOTE_ADDR"];
    
    // 创建连接
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // 检测连接
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
     
    $sql = "INSERT INTO UserList (name, password, canvas, ipad, head, method, see, likes, reg_date)
    VALUES ('".$name."', '".$passwords."', '".$canvas."', '".$ip."', '/resource/icons/heads.png', '".$method."', '[]', '[]', now())";

    if ($conn->query($sql) === TRUE) {
        echo '{
            "code": "200"
        }';
    } else {
        echo '{
            "code": "500"
        }';
    }
    mysqli_close($conn);
?>