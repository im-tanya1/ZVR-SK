        <script src="/resource/js/eruda.js"></script>
        <script src="/resource/js/vconsole.min.js"></script>
        <script>eruda.init();var vConsole = new window.VConsole();</script>




<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/resource/css/Ainfo.css">
        <link rel="stylesheet" href="/resource/css/before.css">
        <link rel="stylesheet" href="/resource/css/article.css">
        <script src="/resource/js/functions.js"></script>
    	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php
    include '../../common.php';
     
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    } 
    
    function endWith($str, $suffix){   
        $length = strlen($suffix);
        if ($length == 0) {
            return true;
        }   
        return (substr($str, -$length) === $suffix);
    } 
    
    $pid = $_SERVER['QUERY_STRING'];
    if(endWith($pid, '=')) {
        $pid = substr($pid, 0, -1);
    }

    $sql = "SELECT elmi, id, typeli, title, content, see, say,autherId, reg_date FROM Passage";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $GLOBALS['hhh'] = true;
        while($row = $result->fetch_assoc()) {
            if ($pid == $row['id']) {
                if ($row["typeli"] !== "无违规") {
                    if($row["typeli"] === "存在违规字符"){
                        echo '
                        <script>
                        window.addEventListener("load", () => {
                            alert("该文章可能存在违规字符")
                        })
                        </script>
                        ';
                    }
                    else{
                        $title = "无法显示文章！";
                        $pid = "gf0";
                        $nr = $row["typeli"];
                        $ll = 1;
                        $hf = 0;
                        $date = "现在";
                        
                        $name = "官方";
                        $head = "/resource/icons/gf.png";
                        $ht = "官方";
                        $GLOBALS['hhh'] = false;
                        break;
                    };
                };
                mysqli_query($conn,"UPDATE Passage SET see=see+1
                WHERE id='".$pid."'");
                
                $title = $row["title"];
                $pid = $row["id"];
                $nr = $row["content"];
                $ll = $row["see"] + 1;
                $hf = $row["say"];
                $date = $row["reg_date"];
                $autherID = $row["autherId"];
                $ht = "默认";

                $sql = "SELECT uid, name, head FROM UserList";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // 输出数据
                    while($row = $result->fetch_assoc()) {
                        if ($row["uid"] == $autherID) {
                            $name = $row["name"];
                            $head = $row["head"];
                        }
                    }
                }

                $GLOBALS['hhh'] = false;
            }
        }
        if($GLOBALS["hhh"]){
            $title = "无法显示文章！";
            $pid = "gf0";
            $nr = "文章不存在";
            $ll = 1;
            $hf = 0;
            $date = "现在";
            
            $name = "官方";
            $head = "/resource/icons/gf.png";
            $ht = "官方";
        }
    }
    $conn->close();
?>
        <meta name="description" content="<?php echo $nr;?>">
        <title><?php echo $title." - ".$name;?></title>
    </head>
    <body>
        <div class="goComeZZ">
            <div style="position: relative;top: 30%;">
                <img style="position: relative;left: 25%;" width="50%" src="/resource/icons/sk.png" alt="" />
            </div>
        </div>

        <div class="hint">
            <span>
                <img class="iii1" onclick="history.back()" src="/resource/icons/back.png" alt="" />
            </span>
           
            <span class="tx"><?php echo $ht."话题";?></span>
            <span>
                <img style="visibility: hidden;position: absolute;right: 5px;top: 12.5px;" src="/resource/icons/back.png" alt="" />
            </span>
        </div>

        <article id="page1">
          <div id="p<?php echo $pid;?>" class="artle">
            <div class="wz">
              <div class="wzinfo">
                <img id="headCl" class="hhed" src="<?php echo $head;?>" alt="" />
                <span id="hasx" class="auther"><?php echo $name;?></span><br>
                <span class="dater"><?php echo $date;?></span>
              </div>
              <div class="wztitle"><?php echo $title;?></div>
              <div id="nr2" class="wznr"><?php echo $nr;?></div><br>
              
              <div class="wzht">
                <div>
                  <img id="notll" src="/resource/icons/ll.png" alt="">
                  <span><?php echo $ll;?></span>
                </div>
                <div>
                  <img id="nothf" src="/resource/icons/hf.png" alt="">
                  <span><?php echo $hf;?></span>
                </div>
                <span class="ht">#ID</span>
              </div><br>
            </div>
          </div>
        </article>
        
        <article style="height: 2%"></article>
        <div style="background-color: var(--whiteColor)">
            全部评论<br>
            <div id="plq">
                <!-- 评论显示区 -->
            </div>
            <div>
                <input type="text" id="contents" placeholder="友善发表评论" />
                <button id="submirs" type="submit">提交</button>
            </div>
        </div>
        
        <script src="/resource/js/jquery.min.js"></script>
        <script src="/resource/js/Bottom-navigation-bar.php?2"></script>
        <script src="/resource/js/article2.js"></script>
    </body>
</html>