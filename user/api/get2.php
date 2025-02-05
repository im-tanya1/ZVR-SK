<?php
include '../../common.php'; 

$uuid = isset($_GET['name']) ? trim($_GET['name']) : null;
if ($uuid === null) {
    echo json_encode([
        "code" => "400",
        "msg" => "缺少参数"
    ]);
    exit;
}

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检查连接
if ($conn->connect_error) {
    echo json_encode([
        "code" => "503",
        "msg" => "连接失败: " . $conn->connect_error
    ]);
    exit;
}

// 使用预处理语句防止SQL注入（尽管在这个例子中只是比较，但仍是最佳实践）
$stmt = $conn->prepare("SELECT uid, name, head, reg_date FROM UserList WHERE name = ?");
$stmt->bind_param("s", $uuid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo json_encode([
            "code" => "200",
            "msg" => "null",
            "uid" => $row["uid"],
            "name" => $row["name"],
            "head" => $row["head"],
            "reg_date" => $row["reg_date"]
        ]);
        exit;
    }
    echo json_encode([
        "code" => "501",
        "msg" => "未找到数据"
    ]);
} else {
    echo json_encode([
        "code" => "500",
        "msg" => "没有数据"
    ]);
}

$stmt->close();
$conn->close();
?>