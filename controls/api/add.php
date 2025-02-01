<?php
    include '../../common.php';
    
    $canvas = $_POST["address"];
    $passwords = $_POST["title"];
    $elmli = $_POST["elmi"];
    $method = $_POST["content"];
    $ip = $_POST["id"];
    $wg = $_POST["wg"];
    $wg2 = "";
    if ($wg == "true") {
        $wg2 = "存在违规字符";
    }
    else{
        $wg2 = "无违规";
    }
    
    $passwords = str_replace("'","\'",$passwords);
    $method = str_replace("'","\'",$method);
    
    // 创建连接
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // 检测连接
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
     
    $sql = "INSERT INTO Passage (elmi, typeli, address, title, content, see, say, autherId, reg_date)
    VALUES ('#page".$elmli."', '".$wg2."', '".$canvas."', '".$passwords."', '".$method."', 0, 0, ".$ip.", now())";

    
    if ($conn->query($sql) === TRUE) {
        $last_id = mysqli_insert_id($conn);
        echo '{
            "code": "200",
            "id": '.$last_id.'
        }';
    } else {
        echo '{
            "code": "500"
        }';
    }
    mysqli_close($conn);
?>