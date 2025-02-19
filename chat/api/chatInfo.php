<?php
include '../../common.php'; 

if (!isset($_POST["address"], $_POST["title"], $_POST["elmi"], $_POST["content"], $_POST["id"], $_POST["wg"])) {
    die(json_encode(array("code" => "400", "message" => "缺少必要的参数")));
}

$canvas = $_POST["address"];
$title = $_POST["title"];
$elmi = $_POST["elmi"];
$content3 = $_POST["content"];
$autherId = $_POST["id"]; 
$wg = $_POST["wg"]; 

$content2 = preg_replace('/<script>/', "", $content3);
$content = preg_replace('/<\/script>/', "", $content2);

$wgStatus = ($wg === "true") ? "存在违规字符" : "无违规";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(array("code" => "500", "message" => "数据库连接失败: " . $conn->connect_error)));
}

$stmt = $conn->prepare("INSERT INTO Passage (elmi, typeli, address, title, content, see, say, autherId, reg_date) VALUES (?, ?, ?, ?, ?, 0, 0, ?, NOW())");

$elmiPrefix = "#page" . $elmi; 
$stmt->bind_param("sssssi", $elmiPrefix, $wgStatus, $canvas, $title, $content, $autherId);

if ($stmt->execute()) {
    $last_id = $stmt->insert_id;
    echo json_encode(array("code" => "200", "id" => $last_id));
} else {
    echo json_encode(array("code" => "500", "message" => "插入失败: " . $stmt->error));
}

$stmt->close();
$conn->close();
?>