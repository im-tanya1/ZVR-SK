<?php
    include '../common.php';

    $conn = new mysqli($servername, $username, $password,$dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 

    $sql = "ALTER TABLE Passage MODIFY COLUMN reg_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
    $result = $conn->query($sql);

    $sql2 = "ALTER TABLE UserList MODIFY COLUMN reg_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
    $result2 = $conn->query($sql2);
?>