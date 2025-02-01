<?php
    include '../../common.php';
     
    // 创建连接
    $uid = $_GET["id"];
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
     
    $sql = "SELECT fromU, toU, content, reg_date FROM chat";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        $times = 0;
        while($row = $result->fetch_assoc()) {
            if ($row["fromU"] == $uid) {
                $times++;
                if ($times != 1) {
                    echo ',{"content": "'.$row["content"].'","time": "'.$row["reg_date"].'", "from": '.$row["fromU"].', "to": '.$row["toU"].'}'; 
                }else{
                    echo '{"content": "'.$row["content"].'","time": "'.$row["reg_date"].'", "from": '.$row["fromU"].', "to": '.$row["toU"].'}'; 
                }
            }
            if ($row["toU"] == $uid) {
                $times++;
                if ($times != 1) {
                    echo ',{"content": "'.$row["content"].'","time": "'.$row["reg_date"].'", "from": '.$row["fromU"].', "to": '.$row["toU"].'}'; 
                }else{
                    echo '{"content": "'.$row["content"].'","time": "'.$row["reg_date"].'", "from": '.$row["fromU"].', "to": '.$row["toU"].'}'; 
                }
            }
        }
        echo "]";
    }else {
        echo "[]";
    }
    $conn->close();
?>