<?php
include '../../common.php';

$name = $_GET['name'];
$passwords = $_GET['password'];
$canvas = $_GET['canvas'];
$type = $_GET['type'];

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 

$sql = "SELECT uid, name, password, canvas FROM UserList WHERE name = ? AND password = ? AND canvas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $passwords, $canvas);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(array("code" => "200", "uid" => $row["uid"]));
    setcookie("userId", $row["uid"], time()+3600);
} else {
    echo json_encode(array("code" => "500", "msg" => "用户名或密码或canvas错误"));
}

$stmt->close();
$conn->close();
?>