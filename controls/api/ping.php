<?php
function get_real_ip() {
    foreach ([
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ] as $key) {
        if (!empty($_SERVER[$key])) {
            $ips = explode(',', $_SERVER[$key]);
            foreach ($ips as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
    }
    return '0.0.0.0';
}

include '../../common.php';

// 输入验证
$required_params = ['uid', 'content', 'belong'];
foreach ($required_params as $param) {
    if (!isset($_POST[$param]) || empty($_POST[$param])) {
        http_response_code(400);
        exit(json_encode(['code' => 400, 'msg' => "Missing required parameter: $param"]));
    }
}

// 参数处理
$uid = $_POST["uid"];
$content = htmlspecialchars($_POST["content"], ENT_QUOTES, 'UTF-8');
$belong = $_POST["belong"];
$ip = get_real_ip();

// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    http_response_code(500);
    exit(json_encode(['code' => 500, 'msg' => 'Database connection failed']));
}

try {
    // 使用事务保证数据一致性
    mysqli_begin_transaction($conn);
    
    // 插入评论（使用预处理语句）
    $stmt1 = $conn->prepare("INSERT INTO Ping (address, content, autherId, belong, reg_date)
                           VALUES (?, ?, ?, ?, NOW())");
    if (!$stmt1) throw new Exception($conn->error);
    
    $address = '哈尔滨'; // 固定值无需参数绑定
    $stmt1->bind_param("ssss", $address, $content, $uid, $belong);
    if (!$stmt1->execute()) throw new Exception($stmt1->error);
    
    // 更新计数（使用预处理语句）
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $belong)) {
        throw new Exception('Invalid belong format');
    }
    
    $stmt2 = $conn->prepare("UPDATE Passage SET say = say + 1 
                           WHERE id = ?");
    if (!$stmt2) throw new Exception($conn->error);
    
    $passage_id = substr($belong, 1);
    $stmt2->bind_param("s", $passage_id);
    if (!$stmt2->execute()) throw new Exception($stmt2->error);
    
    mysqli_commit($conn);
    echo json_encode(['code' => 200]);
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['code' => 500, 'msg' => 'Operation failed']);
} finally {
    $stmt1->close();
    $stmt2->close();
    mysqli_close($conn);
}
?>