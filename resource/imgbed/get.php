<?php
    include '../../common.php';
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT autherId, url, reg_date FROM ImageBed";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        $times = 0;
        while($row = $result->fetch_assoc()) {
            if ($_GET["uid"] == $row["autherId"]) {
                $times++;
                if ($times != 1) {
                    echo ",{";
                    echo '"url" :"' . $row["url"] . '","reg_date": "' . $row["reg_date"] . '"';
                    echo "}";
                }else{
                    echo "{";
                    echo '"url" :"' . $row["url"] . '","reg_date": "' . $row["reg_date"] . '"';
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