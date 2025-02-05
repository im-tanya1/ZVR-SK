<?php
include '../../common.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

// 检测连接
if (!$conn) {
    die(json_encode(["code" => "500", "message" => "数据库连接失败"]));
}

// 检查POST请求中的必要字段
if (!isset($_POST["url"]) || !isset($_POST["uid"])) {
    die(json_encode(["code" => "400", "message" => "缺少必要参数!!!"]));
}

$url = $_POST["url"];
$uid = $_POST["uid"];

$stmt = $conn->prepare("INSERT INTO ImageBed (url, autherId, reg_date) VALUES (?, ?, NOW())");
$stmt->bind_param("si", $url, $uid);

if ($stmt->execute() === FALSE) {
    echo json_encode(["code" => "500", "message" => "日志含义向数据库插入记录失败"]);
} else {
    echo json_encode(["code" => "200", "message" => "记录插入成功"]);
}

$stmt->close();
mysqli_close($conn);
?>