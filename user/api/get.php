<?php
    include '../../common.php';
    
    $uuid = $_GET['id'];
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT uid, name, head FROM UserList";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        while($row = $result->fetch_assoc()) {
            if ($row["uid"] == $uuid) {
                echo '{
                    "code": "200",
                    "msg": "null",
                    "uid": "'.$row["uid"].'",
                    "name": "'.$row["name"].'",
                    "head": "'.$row["head"].'"
                }';
                return 0;
            }
        }
        echo '{
            "code": "501",
            "msg": "未找到数据"
        }'; 
    } else {
        echo '{
            "code": "500",
            "msg": "没有数据"
        }';
    }
    $conn->close();
?>