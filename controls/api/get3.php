<?php
include '../../common.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 假设我们要通过 GET 请求中的 uid 参数过滤作者 ID
$uid = isset($_GET["uid"]) ? intval($_GET["uid"]) : 0; // 使用 intval 确保 uid 是整数

$sql = "SELECT elmi, id, title, content, see, say, autherId, reg_date FROM Passage WHERE autherId = ? ORDER BY reg_date DESC";

// 使用预处理语句防止 SQL 注入
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid); // "i" 表示绑定一个整数参数
$stmt->execute();
$result = $stmt->get_result();

$output = []; // 初始化输出数组
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output[] = [
            "el" => $row["elmi"],
            "id" => $row["id"],
            "title" => $row["title"],
            "nr" => $row["content"],
            "ll" => $row["see"],
            "hf" => $row["say"],
            "date" => $row["reg_date"],
            "autherID" => $row["autherId"]
        ];
    }
    echo json_encode($output); 
} else {
    echo json_encode([]); 
}

$stmt->close();
$conn->close();
?>