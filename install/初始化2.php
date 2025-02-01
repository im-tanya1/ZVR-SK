<?php
    /*
    开发思路：
    文章详情页-使用页面通信实现一个页面
    浏览器指纹cookie-实现记住用户
    
    
    SubMysql信息：
    
    数据库名称	tanyai
    数据库用户	tanyai
    数据库密码	qeAeJwUWUqxePNJI
    数据库地址	mysql.sqlpub.com:3306
    注册邮箱	tanya_a@qq.com
    注意	密码只显示一次，请注意保存。
    为保障数据库运行安全，密码严禁泄漏到公共环境！！！（如：csdn、zhihu、github等）发现即永久锁定。
    */
    
    include '../common.php';    // 创建连接
    $conn = new mysqli($servername, $username, $password,$dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
    
    try {
        $sql = "CREATE TABLE UserList (
        uid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        type VARCHAR(6) DEFAULT '无违规',
        name VARCHAR(15) NOT NULL,
        password VARCHAR(32) NOT NULL,
        canvas VARCHAR(32) NOT NULL,
        ipad VARCHAR(10) NOT NULL,
        head VARCHAR(30) NOT NULL,
        method VARCHAR(6) NOT NULL,
        see VARCHAR(20) NOT NULL,
        likes VARCHAR(20) NOT NULL,
        reg_date TIMESTAMP
        )";
        if (mysqli_query($conn, $sql)) {
            echo "数据表 User 创建成功";
        } else {
            echo "创建数据表错误: " . mysqli_error($conn);
    }
    // 文章
    } catch (Exception $eee) {
        echo "UserList创建错误";
    }
    mysqli_close($conn);
?>