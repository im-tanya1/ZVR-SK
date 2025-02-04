function skipWeb(url) {
    location.href = url
}

window.addEventListener("load", function() {
    console.log(userBiLi(), ~~(userBiLi() * 10))
    if (~~(userBiLi() * 10) !== 5 && ~~(userBiLi() * 10) !== 4) {
        document.querySelector(".goComeZZ div img").style.display = "none"
        writeWindowTip(1)
        return;
    }

    setTimeout(() => {
        $(".goComeZZ").fadeOut(200)
    }, 500);
})

/*
function stopEvent(el,event){
    this.pd = true
    el['on' + event] = () => {
        this.pd = false
    }
    while (this.pd) {
        this.num++
        console.log(this.num)
    }
}
function stopSleep(end){
    this.num = 0
    while (this.num <= end) {
        this.num++
        console.log(this.num)
    }
}
function stopSleep2(time){
    this.num = 0
    console.time('sleep')
    while (console.timeLog('sleep') * 1000 <= time) {
        this.num++
        console.log(this.num)
        console.timeEnd('sleep')
    }
}
const sleep = (delay) => new Promise((resolve) => void setTimeout(resolve, delay));
*/

function sleep(times){
    const startTime = Date.now()
    while(1){
        if (Date.now() - startTime >= times) {
            break;
        }
    }
    return true;
}

function uploadError(){
    
}
function script(src){
    const scri = document.createElement("creat")
    scri.src = src
    document.body.appendChild(scri)
}

function waterMark(text){
    let waterMarks = document.createElement("div")
    waterMarks.style.pointerEvents = "none"
    waterMarks.style.position = "fixed"
    waterMarks.style.left = "0"
    waterMarks.style.top = "0"
    waterMarks.style.width = "100%"
    waterMarks.style.height = "100%"
    waterMarks.style.zIndex = "99"
    waterMarks.style.opacity = "0.05"
    
    for (var j = 0; j < 9; j++) {
        for (var i = 0; i < 4; i++) {
            let ii = document.createElement("span")
            let textJL = text.split("").length * 15
            let jj = innerWidth / 3
            jj = jj * 3 - textJL
            jj = jj / 3

            ii.innerText = text
            ii.style.position = "fixed"
            ii.style.fontSize = "15px"
            ii.style.left = jj * i 
            ii.style.top = innerHeight / 9 * j
            // jj * 5 - textJL / 4
            waterMarks.appendChild(ii)
        }
    }
    
    document.body.appendChild(waterMarks)
}

function waterMarkImg(Img, auther){
    return new Promise((resolve, reject) => {
        console.log("被调用")
        var can = document.createElement("canvas")
        var ctx = can.getContext("2d");
        
        var image = document.createElement("img")
        image.src = Img
        var bl = image.width / innerWidth
        can.width = innerWidth * devicePixelRatio
        can.height = image.height / bl * devicePixelRatio
        
        image.onload = () => {
            ctx.drawImage(image, 0 ,0, innerWidth * devicePixelRatio, image.height / bl * devicePixelRatio)
            
            ctx.font="30px Arial";
            ctx.fillStyle = "grey";
            ctx.fillText("图片来源于 " + auther, 20, 50);
            try{
                var res1 = can.toDataURL();
            }
            catch(err){
                console.log(err)
                resolve(Img)
            }
            if (res1 != "data:,") {
                resolve(res1)
            }else{
                //setTimeout(() => {
                waterMarkImg(Img, auther).then((res2) => {
                    resolve(res2)
                })
                //}, 500)
            }
        }
    })
}

function tzdWZ(pid){
    window.open(`/controls/datail/index.php?${pid}`)
    // window.open(`/controls/datail/${pid}.html`)
}

window.onerror = function(message, source, lineno, colno, error) {
    switch (error) {
        case 'SyntaxError: Unexpected token } in JSON at position 77':
            alert('文章中用户ID异常')
            break;

        default:
            console.log("error:", error)
            uploadError()
    }
}
window.addEventListener("load", () => {
    if (localStorage.getItem("Uname")) {
        waterMark(localStorage.getItem("Uname"))
    }else{
        waterMark("未登录")
    }
})

function userBiLi(){
    return innerWidth / innerHeight
}
function writeWindowTip(){
    const Tip = document.createElement("div")
    var styles = {
        width: "100%",
        height: "100%",
        position: "fixed",
        left: "0",
        top: "0",
        backgroundColor: "black",
        zIndex: "10",
        opacity: "0",
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
    }
    Tip.id = "tips"
    for (let i in styles) {
        Tip.style[i] = styles[i]
    }
    document.body.appendChild(Tip)
    
    let k = new Image()
    k.src = "/resource/icons/tip3.gif"
    let styles2 = {
        width: "100%"
    }
    for (let i in styles2) {
        k.style[i] = styles2[i]
    }
    Tip.appendChild(k)
    
    setTimeout(() => {
        let j2 = setInterval(() => {
            if (+tips.style.opacity <= 0){
                tips.remove()
                clearInterval(j)
                return;
            }
            tips.style.opacity = +tips.style.opacity - 0.01
        }, 5)
        $(".goComeZZ").fadeOut(0)
    }, 3000)
    
    let tips = document.getElementById("tips")
    let j = setInterval(() => {
        if (+tips.style.opacity >= 1){
            clearInterval(j)
            return;
        }
        tips.style.opacity = +tips.style.opacity + 0.01
    }, 5)
}

/*
空值合并运算符 (??)
a ?? b

逻辑或运算符 (||)
a || b

可选链运算符（?.）
Object?.a
如果使用此运算符访问的对象或调用的函数是 undefined 或 null，则表达式会短路并计算为 undefined，而不是抛出错误。
?. ?? ||
*/


/** 春节花活：点击文字 */
window.addEventListener("load", function() {
    (function () {
      var a_idx = 0;
      window.onclick = function (event) {
        var a = new Array("❤富强❤", "❤民主❤", "❤文明❤", "❤和谐❤", "❤自由❤", "❤平等❤", "❤公正❤", "❤法治❤", "❤爱国❤",
          "❤敬业❤", "❤诚信❤", "❤友善❤");

        var heart = document.createElement("b"); //创建b元素
        heart.onselectstart = new Function('event.returnValue=false'); //防止拖动

        document.body.appendChild(heart).innerHTML = a[a_idx]; //将b元素添加到页面上
        a_idx = (a_idx + 1) % a.length;
        heart.style.cssText = "position: fixed;left:-100%;"; //给p元素设置样式

        var f = 12, // 字体大小
          x = event.clientX - f * 2, // 横坐标
          y = event.clientY - f * 2, // 纵坐标
          c = randomColor(), // 随机颜色
          a = 1, // 透明度
          s = 1.2; // 放大缩小

        var timer = setInterval(function () { //添加定时器
          if (a <= 0) {
            document.body.removeChild(heart);
            clearInterval(timer);
          } else {
            heart.style.cssText = "font-size:12px;cursor: default;position: fixed;color:" +
              c + ";left:" + x + "px;top:" + y + "px;opacity:" + a + ";transform:scale(" +
              s + ");";

            y--;
            a -= 0.016;
            s += 0.002;
          }
        }, 10)

      }
      // 随机颜色
      function randomColor() {

        return "rgb(" + (~~(Math.random() * 255)) + "," + (~~(Math.random() * 255)) + "," + (~~(Math
          .random() * 255)) + ")";

      }
    }());
})

