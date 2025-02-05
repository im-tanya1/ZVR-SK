<?php
include '../../common.php';

$uuid = $_GET['id'];
// 对$uuid进行基本的验证，确保它是一个非空的字符串（这里假设uid是字符串类型）
if (empty($uuid)) {
    die(json_encode([
        "code" => "400",
        "msg" => "无效的UID"
    ]));
}

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "code" => "500",
        "msg" => "连接失败: " . $conn->connect_error
    ]));
}

// 使用预处理语句防止潜在的SQL注入风险（尽管在这个例子中$uuid不直接用于查询）
$stmt = $conn->prepare("SELECT uid, name, head FROM UserList WHERE uid = ?");
$stmt->bind_param("i", $uuid); // 假设uid是字符串类型，如果是整数则使用"i"
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "code" => "200",
        "msg" => "null",
        "uid" => $row["uid"],
        "name" => $row["name"],
        "head" => $row["head"]
    ]);
} else {
    echo json_encode([
        "code" => "501",
        "msg" => "未找到数据"
    ]);
}

$stmt->close();
$conn->close();
?>