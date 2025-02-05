<?php
    include '../../common.php';
    
    function get_real_ip(){
        foreach ([
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ] as $key) {
            if (!empty($_SERVER[$key])) {
                $ips = explode(',', $_SERVER[$key]);
                foreach ($ips as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                        return $ip;
                    }
                }
            }
        }
        return '0.0.0.0';
    }
    $canvas = $_POST["canvas"];
    $name = $_POST["name"];
    $passwords = $_POST["password"];
    $method = $_POST["method"];
    $ip = get_real_ip();
    
    // 建议添加基本输入验证
    if (empty($name) || strlen($name) > 10) {
        die(json_encode(["code" => "400", "msg" => "用户名为空或过长"]));
    }
    
    // 创建连接
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // 检测连接
    if (!$conn) {
        die(json_encode(["code" => "500", "msg" => "链接错误"]));
    }
     
    // 使用预处理语句
    $sql = "INSERT INTO UserList (
                name, 
                password, 
                canvas, 
                ipad, 
                head, 
                method, 
                see, 
                likes, 
                reg_date
            ) VALUES (?, ?, ?, ?, '/resource/icons/heads.png', ?, '[]', '[]', NOW())";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die(json_encode(["code" => "500", "msg" => "Prepare failed: " . $conn->error]));
    }

    // 绑定参数并设置类型（s=string）
    $stmt->bind_param("sssss", $name, $passwords, $canvas, $ip, $method);

    if ($stmt->execute()) {
        echo json_encode(["code" => "200"]);
    } else {
        echo json_encode(["code" => "500", "msg" => "Execute failed: " . $stmt->error]);
    }
    
    $stmt->close();
    mysqli_close($conn);
?>
