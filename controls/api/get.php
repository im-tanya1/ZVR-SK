<?php
include '../../common.php';

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die(json_encode([
        "code" => "500"
    ]));
}

$sql = "SELECT elmi, id, title, content, see, say, autherId, reg_date FROM Passage ORDER BY reg_date DESC";
$result = $conn->query($sql);

$output = array(); 

if ($result->num_rows > 0) {
    // 输出数据
    while ($row = $result->fetch_assoc()) {
        $output[] = array(
            "el" => $row["elmi"],
            "id" => intval($row["id"]), 
            "title" => $row["title"], 
            "nr" => $row["content"], 
            "ll" => intval($row["see"]), 
            "hf" => intval($row["say"]), 
            "date" => $row["reg_date"],
            "autherID" => intval($row["autherId"]) 
        );
    }
}
echo json_encode($output);

$conn->close();
?>