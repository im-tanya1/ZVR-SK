<?php
    include '../../common.php';
    
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败"); 
    }
    $sql = "SELECT id, type, content, belong, autherId, reg_date FROM Ping WHERE belong = ? ORDER BY reg_date DESC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL预处理失败: " . $conn->error);
    }
    $stmt->bind_param("s", $_GET["pid"]);
    if (!$stmt->execute()) {
        die("执行查询失败: " . $stmt->error);
    }
    $result = $stmt->get_result();
    
    $output = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output[] = [
                'id' => $row['id'],
                'type' => $row['type'],
                'content' => $row['content'],
                'belong' => $row['belong'],
                'autherId' => $row['autherId'],
                'date' => $row['reg_date']
            ];
        }
    }
    echo json_encode($output);
    
    $stmt->close();
    $conn->close();
?>
