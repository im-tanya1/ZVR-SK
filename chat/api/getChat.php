<?php
/*
include '../../common.php';

// 验证参数有效性
if (!isset($_GET["uo"], $_GET["ut"]) || !ctype_digit($_GET["uo"]) || !ctype_digit($_GET["ut"])) {
    echo json_encode([]);
    exit;
}

$uid = (int)$_GET["uo"];
$tid = (int)$_GET["ut"];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("连接失败: " . $conn->connect_error);
    }
    
    // 设置字符集
    $conn->set_charset("utf8mb4");

    // 使用预处理语句防止SQL注入
    $stmt = $conn->prepare("
        SELECT fromU, toU, content, reg_date 
        FROM chat 
        WHERE (fromU = ? AND toU = ?) 
           OR (fromU = ? AND toU = ?)
        ORDER BY reg_date
    ");
    
    if (!$stmt) {
        throw new Exception("预处理失败: " . $conn->error);
    }

    $stmt->bind_param("iiii", $uid, $tid, $tid, $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'content' => $row['content'],
            'time' => $row['reg_date'],
            'from' => (int)$row['fromU'],
            'to' => (int)$row['toU']
        ];
    }

    echo json_encode($messages, JSON_UNESCAPED_UNICODE);

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    error_log($e->getMessage()); 
    echo json_encode([]);
}
*/
include '../../common.php';

// 验证参数有效性
if (!isset($_GET["uo"], $_GET["ut"]) || !ctype_digit($_GET["uo"]) || !ctype_digit($_GET["ut"])) {
    echo json_encode([]);
    exit;
}

$uid = (int)$_GET["uo"];
$tid = (int)$_GET["ut"];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("连接失败: " . $conn->connect_error);
    }
    
    // 设置字符集
    $conn->set_charset("utf8mb4");

    // 使用事务保证数据一致性
    $conn->begin_transaction();

    // 第一部分：查询聊天记录
    $stmt = $conn->prepare("
        SELECT fromU, toU, content, reg_date 
        FROM chat 
        WHERE (fromU = ? AND toU = ?) 
           OR (fromU = ? AND toU = ?)
        ORDER BY reg_date
    ");
    
    if (!$stmt) {
        throw new Exception("查询预处理失败: " . $conn->error);
    }

    $stmt->bind_param("iiii", $uid, $tid, $tid, $uid);
    if (!$stmt->execute()) {
        throw new Exception("查询执行失败: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = [
            'content' => $row['content'],
            'time' => $row['reg_date'],
            'from' => (int)$row['fromU'],
            'to' => (int)$row['toU']
        ];
    }
    $stmt->close();

    // 第二部分：标记已读状态（新增功能）
    $updateStmt = $conn->prepare("
        UPDATE chat 
        SET isRead = 1 
        WHERE fromU = ? AND toU = ?
          AND isRead = 0 
    ");
    
    if (!$updateStmt) {
        throw new Exception("更新预处理失败: " . $conn->error);
    }
    
    $updateStmt->bind_param("ii", $tid, $uid); 
    if (!$updateStmt->execute()) {
        throw new Exception("更新执行失败: " . $updateStmt->error);
    }
    $updateStmt->close();

    // 提交事务
    $conn->commit();

    echo json_encode($messages, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    // 回滚事务并记录错误
    $conn->rollback();
    error_log($e->getMessage());
    echo json_encode([]);
} finally {
    // 确保关闭连接
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>