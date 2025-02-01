<?php
    include '../../common.php';
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
    
    $pid = $_GET['id'];
    $sql = "SELECT type, address, content, belong, autherId, reg_date FROM Ping";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        while($row = $result->fetch_assoc()) {
            if ($pid == $row['belong']) {
                if ($row["type"] == "无违规") {
                    echo "{";
                    echo '"address": "'.$row["address"].'", "content": "'.$row["content"].'", "autherId": "'.$row["autherId"].'", "date": "'.$row["reg_date"].'"';
                    echo "}";
                }
            }
        }
        echo "]";
    } else {
        echo "[]";
    }
    $conn->close();
?>