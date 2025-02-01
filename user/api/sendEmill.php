<?php
    $to = "1294036993@qq.com";         // 邮件接收者
    $subject = "参数邮件";                // 邮件标题
    $message = "Hello! 这是邮件的内容。";  // 邮件正文
    $from = "tanya_a@qq.com";   // 邮件发送者
    $headers = "From:" . $from;         // 头部信息设置
    if(mail($to,$subject,$message,$headers)){
        echo '邮件发送成功';
    }else{
        echo '邮件发送失败';
    }
?>