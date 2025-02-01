<?php
    include '../../common.php';
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT id, type, content, belong, autherId, reg_date FROM Ping ORDER BY reg_date DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        $times = 0;
        while($row = $result->fetch_assoc()) {
            if ($_GET["pid"] == $row["belong"]) {
                $times++;
                if ($times != 1) {
                    echo ",{";
                    echo '"id": ' . $row["id"] . ',"type": "' . $row["type"] . '","content": "' . $row["content"] . '","belong": "' . $row["belong"] . '","autherId": ' . $row["autherId"] . ',"date": "' . $row["reg_date"] . '"';
                    echo "}";
                }else{
                    echo "{";
                    echo '"id": ' . $row["id"] . ',"type": "' . $row["type"] . '","content": "' . $row["content"] . '","belong": "' . $row["belong"] . '","autherId": ' . $row["autherId"] . ',"date": "' . $row["reg_date"] . '"';
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