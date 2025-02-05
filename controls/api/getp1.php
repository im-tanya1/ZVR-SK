<?php
    include '../../common.php';
     
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
    
    $pid = isset($_GET['id']) && substr($_GET['id'], 0, 1) === "p" ? (int)$_GET['id'] : null;
    
    // 检查$pid是否有效
    if ($pid === null) {
        echo "[]";
        $conn->close();
        exit;
    }
    
    // 使用WHERE子句来筛选数据
    $sql = "SELECT type, address, content, belong, autherId, reg_date FROM Ping WHERE belong = ?";
    // 使用预处理语句来防止SQL注入
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // 初始化数组来存储结果
    $output = [];
    
    if ($result->num_rows > 0) {
        // 输出数据
        while($row = $result->fetch_assoc()) {
            if ($row["type"] == "无违规") {
                $output[] = [
                    "address" => $row["address"],
                    "content" => $row["content"],
                    "autherId" => $row["autherId"],
                    "date" => $row["reg_date"]
                ];
            }
        }
        // 使用json_encode输出JSON格式的数据
        echo json_encode($output);
    } else {
        // 如果没有结果，输出空数组
        echo json_encode([]);
    }
    
    // 关闭连接
    $stmt->close();
    $conn->close();
?>