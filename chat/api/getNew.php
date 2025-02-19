<?php
include '../../common.php';
header('Content-Type: application/json');
set_time_limit(0); // 取消脚本执行时间限制

$timeout = 27; // 服务端超时时间
$startTime = time();
$id = (int)$_GET["id"];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(422);
    echo json_encode([]);
    $conn->close();
}
$conn->set_charset("utf8mb4");
$stmt = $conn->prepare("
    SELECT *
    FROM chat
    WHERE toU = ?
    AND isRead = 0
");
    
if (!$stmt) {
    http_response_code(423);
    echo json_encode([]);
    $conn->close();
}
$stmt->bind_param("i", $id);

while (time() - $startTime < $timeout) {
    $res = [];
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $res[] = [
            'id' => $row['fromU'],
            'message' => $row["content"],
            'time' => $row["reg_date"]
        ];
    }
    if (!empty($res)) {
        http_response_code(200);
        echo json_encode($res);
        $stmt->close();
        $conn->close();
        exit;
    }
    sleep(2);
};

$stmt->close();
$conn->close();
http_response_code(500);
echo json_encode([]);
?>