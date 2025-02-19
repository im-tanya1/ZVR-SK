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

// 设置默认值
$title = "无法显示文章！";
$pid = "0";
$nr = "文章不存在";
$ll = 1;
$hf = 0;
$date = "现在";
$name = "官方";
$head = "/resource/icons/gf.png";
$ht = "官方";
$autherID = null;
$showAlert = false;

try {
    // 创建数据库连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("连接失败: " . $conn->connect_error);
    }

    // 获取并验证PID
    $pid = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

    // 使用预处理语句防止SQL注入
    $stmt = $conn->prepare("
        SELECT 
            p.elmi, p.id, p.typeli, p.title, p.content, 
            p.see, p.say, p.autherId, p.reg_date,
            u.name, u.head
        FROM Passage p
        LEFT JOIN UserList u ON p.autherId = u.uid
        WHERE p.id = ?
    ");
    if (!$stmt) {
        throw new Exception("数据库查询准备失败: " . $conn->error);
    }

    $stmt->bind_param("s", $pid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // 处理违规类型
        if ($row["typeli"] !== "无违规") {
            if ($row["typeli"] === "存在违规字符") {
                $showAlert = true;
            } else {
                // 直接使用默认值显示违规信息
                $nr = $row["typeli"];
                $date = date("Y-m-d H:i:s");
                $stmt->close();
                $conn->close();
                exit;
            }
        }

        // 更新查看次数（原子操作）
        $conn->query("UPDATE Passage SET see = see + 1 WHERE id = '$pid'");

        // 赋值变量
        $title = $row["title"];
        $nr = $row["content"];
        $ll = $row["see"] + 1;
        $hf = $row["say"];
        $date = $row["reg_date"];
        $name = htmlspecialchars($row["name"] ?? '官方', ENT_QUOTES, 'UTF-8');
        $head = htmlspecialchars($row["head"] ?? '/resource/icons/gf.png', ENT_QUOTES, 'UTF-8');
        $ht = "默认";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // 记录错误日志
    error_log($e->getMessage());
    // 保留默认值显示错误信息
}

// 显示警告（如果需要）
if ($showAlert) {
    echo '<script>window.addEventListener("load", () => { alert("该文章可能存在违规字符") })</script>';
}
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