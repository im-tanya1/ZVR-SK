        <script src="/resource/js/eruda.js"></script>
        <script src="/resource/js/vconsole.min.js"></script>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/resource/css/before.css">
        <script src="/resource/js/functions.js"></script>
    	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <?php 
            $eb1 = $_SERVER['QUERY_STRING'];
            $err = explode(',', $eb1)[0];
            $url = explode(',', $eb1)[1];
        ?>
        <title>错误<?php echo $err;?> - ZVR神坑工作室</title>
    </head>
    <body>
        <div class="goComeZZ">
            <div style="position: relative;top: 30%;">
                <img style="position: relative;left: 25%;" width="50%" src="/resource/icons/sk.png" alt="" />
            </div>
        </div>
        <div class="hint">
            <span>
                <img onclick="history.back()" style="position: absolute;left: 5px;top: 12.5px;" src="/resource/icons/back.png" alt=">" />
            </span>
           
            <span>错误<?php echo $err;?></span>
            <span>
                <img style="visibility: hidden;position: absolute;right: 5px;top: 12.5px;" src="/resource/icons/back.png" alt="" />
            </span>
        </div>
        
        <div style="font-size: 14px;">
            你正在试图访问
            <span style="color: var(--themeColor);">
                <?php echo $url?>
            </span>
            并发出了请求，但在此过程中，服务器响应了
            <span style="color: var(--themeColor);">
                <?php echo $err;?>
            </span>
            错误码。根据此错误码，我们推断这通常是由于<span id="abj" style="color: var(--themeColor)"></span>。注意您的请求尚未成功！
        </div>
        
        <div style="position: absolute;width: 100%;top: 50%;">
            <div style="text-align: center;width: 100%;font-size: 17px;">
                将在<span id="hhj" style="color: var(--themeColor);">10</span>秒后<span onclick="window.location.href = '/'" style="color: var(--themeColor);">返回</span>
            </div>
        </div>
        <script>
            var ec = <?php echo $err;?>;
            function r(text){
                abj.innerText = text;
            }
            
            switch (ec) {
              case 404:
                r("服务器未找到您所请求的文件或目录")
                break;
              case 403:
                r("您没有权限访问该文件或目录")
                break;
              case 402:
                r("您没有付款")
                break;
              case 401:
                r("您没有获得授权")
              default:
                r("其他原因");
            }
        
            setInterval(() => {
                hhj.innerText = Number(hhj.innerText) -1
                if(hhj.innerText == 0){
                    window.location.href = "/"
                }
            }, 1000)
        </script>
        <script src="/resource/js/jquery.min.js"></script>
        <script src="/resource/js/Bottom-navigation-bar.php?9"></script>
    </body>
</html>