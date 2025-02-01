<?php
    include '../../common.php';
    
    $name = $_GET['name'];
    $passwords = $_GET['password'];
    $canvas = $_GET['canvas'];
    $type = $_GET['type'];
    // echo $name.$passwords.$canvas;
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT uid, name, password, canvas FROM UserList";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        while($row = $result->fetch_assoc()) {
            if ($row["name"] == $name && $row["password"] == $passwords) {
                if ($row["canvas"] == $canvas) {
                    echo '{
                        "code": "200",
                        "uid": "'.$row["uid"].'"
                    }';
                    setcookie("userId", $row["uid"], time()+3600);
                    return 0;
                }else {
                    echo '{
                        "code": "200",
                        "uid": "'.$row["uid"].'",
                        "msg": "用户canvas错误"
                    }';
                    setcookie("userId", $row["uid"], time()+3600);
                    return 0;
                }
            }
        }
            echo '{
                "code": "500",
                "msg": "用户名或密码错误"
            }'; 
    } else {
        echo '{
            "code": "502",
            "msg": "暂无用户数据"
        }';
    }
    $conn->close();
?>