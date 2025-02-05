<?php
include '../../common.php';

// 确保uid参数存在
if (!isset($_GET["uid"])) {
    die(json_encode(array("error" => "uid参数缺失")));
}

// 验证和清理uid（这里简单使用intval，根据实际情况可能需要更复杂的验证）
$uid = intval($_GET["uid"]);

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("error" => "连接失败: " . $conn->connect_error)));
}

$sql = "SELECT autherId, url, reg_date FROM ImageBed WHERE autherId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; 
    }
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>