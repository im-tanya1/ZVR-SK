<?php
include '../../common.php';

// 验证参数有效性
if (!isset($_GET["id"]) || !ctype_digit($_GET["id"])) {
    echo json_encode([]);
    exit;
}

$uid = (int)$_GET["id"];
$partners = [];

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("连接失败: " . $conn->connect_error);
    }
    
    // 设置字符集
    $conn->set_charset("utf8mb4");

    // 使用预处理语句防止SQL注入
    $stmt = $conn->prepare("
        SELECT DISTINCT CASE
            WHEN fromU = ? THEN toU
            ELSE fromU
        END AS partner_id
        FROM chat
        WHERE fromU = ? OR toU = ?
        ORDER BY partner_id
    ");
    
    if (!$stmt) {
        throw new Exception("预处理失败: " . $conn->error);
    }

    $stmt->bind_param("iii", $uid, $uid, $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $partners[] = (int)$row['partner_id'];
    }

    echo json_encode($partners, JSON_UNESCAPED_UNICODE);

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    error_log($e->getMessage()); // 记录错误日志
    echo json_encode([]);
}
?>