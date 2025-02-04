<?php
    function get_real_ip(){ 
        $ip=false; 
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){ 
            $ip=$_SERVER['HTTP_CLIENT_IP']; 
        }
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ 
            $ips=explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']); 
            if($ip){ array_unshift($ips, $ip); $ip=FALSE; }
            for ($i=0; $i < count($ips); $i++){
                if(!eregi ('^(10│172.16│192.168).', $ips[$i])){
                    $ip=$ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']); 
    }

    include '../../common.php';
    
    $uid = $_POST["uid"];
    $content = $_POST["content"];
    $belong = $_POST["belong"];
    $ip = get_real_ip();
    // 创建连接
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // 检测连接
    if (!$conn) {
        mysqli_close($conn);
        die('{
            "code": "500" 
        }');
    }
     
    $sql = "INSERT INTO Ping (address, content, autherId, belong, reg_date)
    VALUES ('哈尔滨', '".$content."', '".$uid."', '".$belong."', now())";

    
    if ($conn->query($sql) === FALSE) {
        mysqli_close($conn);
        die('{
            "code": "500"
        }');
    }else{
        mysqli_query($conn,"UPDATE Passage SET say=say+1
        WHERE id='".substr($belong, 1)."'");
        
        echo '{
            "code": "200"
        }';
    }
    mysqli_close($conn);
?>