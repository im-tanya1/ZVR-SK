<?php
    include '../common.php';
    // 创建连接
    $conn = new mysqli($servername, $username, $password,$dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
    
    try {
        $sql = "CREATE TABLE Passage (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        elmi VARCHAR(6) NOT NULL,
        typeli VARCHAR(2555) DEFAULT '无违规',
        address VARCHAR(10) NOT NULL,
        title VARCHAR(30) NOT NULL,
        content VARCHAR(2555) NOT NULL,
        see INT(6) NOT NULL,
        say INT(6) NOT NULL,
        autherId INT(6) NOT NULL,
        reg_date TIMESTAMP
        )";
        if (mysqli_query($conn, $sql)) {
            echo "数据表 Passage 创建成功";
        } else {
            echo "创建数据表错误: " . mysqli_error($conn);
    }
    // 文章
    } catch (Exception $eee) {
        echo "Passage创建错误";
    }
    mysqli_close($conn);
?>