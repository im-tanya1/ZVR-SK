<?php
    include '../../common.php';
     
    // 创建连接
    $uid = $_GET["id"];
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT fromU, toU FROM chat";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        $times = 0;
        $lists = [];
        while($row = $result->fetch_assoc()) {
            if ($row["fromU"] == $uid) {
                $times++;
                if (!in_array($row["toU"], $lists, false)) {
                    if ($times != 1) {
                        echo ",".$row["toU"]; 
                    }else{
                        echo $row["toU"]; 
                    }
                    $lists[] = $row["toU"];
                }
            }
            if ($row["toU"] == $uid) {
                $times++;
                if (!in_array($row["toU"], $lists, false)) {
                    if ($times != 1) {
                        echo ",".$row["fromU"]; 
                    }else{
                        echo $row["fromU"]; 
                    }
                    $lists[] = $row["toU"];
                }
            }
        }
        echo "]";
    } else {
        echo "[]";
    }
    $conn->close();
?>