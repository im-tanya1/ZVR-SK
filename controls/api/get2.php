<?php
    die("此接口已弃用");

    include '../../common.php';
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
    
    $pid = $_GET['id'];
    $sql = "SELECT elmi, id, title, content, see, say,autherId, reg_date FROM Passage";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // 输出数据
        echo '[';
        while($row = $result->fetch_assoc()) {
            if ($pid == $row['id']) {
                echo "{";
                echo '"el" :"' . $row["elmi"] . '","id": ' . $row["id"] . ',"title": "' . $row["title"] . '","nr": "' . $row["content"] . '","ll": ' . $row["see"] + 1 . ',"hf": ' . $row["say"] . ',"date": "' . $row["reg_date"] . '","autherID": ' . $row["autherId"];
                    echo "}";
                    
                mysqli_query($conn,"UPDATE Passage SET see=see+1
                WHERE id='".$row["id"]."'");
            }
        }
        echo "]";
    } else {
        echo "[]";
    }
    $conn->close();
?>