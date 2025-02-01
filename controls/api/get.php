<?php
    include '../../common.php';
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT elmi, id, title, content, see, say,autherId, reg_date FROM Passage ORDER BY reg_date DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        $times = 0;
        while($row = $result->fetch_assoc()) {
            $times++;
            if ($times != 1) {
                echo ",{";
                echo '"el": "' . $row["elmi"] . '","id": ' . $row["id"] . ',"title": "' . $row["title"] . '","nr": "' . $row["content"] . '","ll": ' . $row["see"] . ',"hf": ' . $row["say"] . ',"date": "' . $row["reg_date"] . '","autherID": ' . $row["autherId"];
                echo "}";
            }else{
                echo "{";
                echo '"el": "' . $row["elmi"] . '","id": ' . $row["id"] . ',"title": "' . $row["title"] . '","nr": "' . $row["content"] . '","ll": ' . $row["see"] . ',"hf": ' . $row["say"] . ',"date": "' . $row["reg_date"] . '","autherID": ' . $row["autherId"];
                echo "}";
            }
        }
        echo "]";
    } else {
        echo "[]";
    }
    $conn->close();
?>