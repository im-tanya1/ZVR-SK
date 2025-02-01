window.count1 = 0
function getUid(n){
    var ii = {
        sixhdhhs: localStorage.getItem("userId"),
        paoxnwqa: localStorage.getItem("Uname")
    }
    return ii[n]
}
function load1() {
    $.ajax({
        url: "/user/api/get.php",
        method: "get",
        data: {
            id: localStorage.getItem("userId")
        },
        success: function(res){
            let res3 = JSON.parse(res)
            yh.innerText = res3.name
            txi.src = res3.head
            
            txi.onload = function(){
                tpzs.width = tpzs.width * devicePixelRatio
                tpzs.height = tpzs.height * devicePixelRatio
                let ctx = tpzs.getContext("2d");
                
                ctx.filter = "blur(3px)";
                ctx.font = "35px serif";

                let h1 = canhei * devicePixelRatio
                ctx.drawImage(txi, (tpzs.width - h1) / 2, 0, h1, h1)
                
                ctx.textAlign="center";
                ctx.filter = "blur(0px)";
                ctx.font = "35px serif";
                ctx.fillText("Z", 30, 50);
                ctx.fillText("V", 30, 140);
                ctx.fillText("R", 30, 230);
                // snh tx dyh lsr zyx lsh

                let w1 = (innerWidth - 30 * devicePixelRatio) * 2 - 30
                
                console.log(w1)
                ctx.fillText("神", w1, 50);
                ctx.fillText("坑", w1, 230);
            }
        }
    })
    // 用户状态
}
function load2() {
    // 专属图床
    $.ajax({
        url: "/resource/imgbed/get.php",
        method: "get",
        data: {
            uid: localStorage.getItem("userId")
        },
        success: function(ress){
            let res = JSON.parse(ress)
            res.forEach(v => {
                const image = document.createElement("img")
                image.src = "/resource/icons/loading.gif"
                waterMarkImg(v.url, localStorage.getItem("Uname")).then((base) => {
                    image.src = base
                    image.style.width = '100%'
                })
                
                const dii = document.createElement("div")
                dii.className = "imgc"
                dii.appendChild(image)
                fun2.appendChild(dii)
            })
        }
    })
}
function load3(argument) {
    // 评论管理
}
async function load4(argument) {
    // 我的文章
    function renderArticle(optss) {
        const ori = $('#fun4').html()
        $('#fun4').html(ori + `
            <div onclick="tzdWZ(${optss.id})" id="p${optss.id}" class="artle">
            <article class="interval"></article>
            <div class="wz">
            <div class="wzinfo">
            <img class="hhed" src="${optss.head}" alt="" />
            <span class="auther">${optss.auther}</span><br>
            <span class="dater">${optss.date}</span>
            </div>
    
            <div class="wztitle">${optss.title}</div>
            <div class="wznr">${optss.nr}</div><br>
            <div class="wzht">
            <div>
            <img src="/resource/icons/ll.png" alt="">
            <span>${optss.ll}</span>
            </div>
            <div>
            <img src="/resource/icons/hf.png" alt="">
            <span>${optss.hf}</span>
            </div>
    
            <span class="ht">#默认</span>
            </div><br>
            </div>
            </div>
            `)
    }
    
    await $.ajax({
        url:"/user/api/get2.php",
        data: {
            name: localStorage.getItem("Uname")
        },
        success: function(ress){
            let res = JSON.parse(ress)
            window.auther = res.name
            window.head = res.head
            uiid.innerText = res.uid
            regg.innerText = res['reg_date']
        }
    })
    
    $.ajax({
        url: "/controls/api/get3.php",
        method: "get",
        data: {
            uid: localStorage.getItem("userId")
        },
        success: function(ress){
            let resi = JSON.parse(ress)
            resi.forEach(v => {
                v.auther = window.auther
                v.head = window.head
                window.count1++
                console.log(v)
                renderArticle(v)
                tzs.innerText = window.count1
            })
        }
    })
}

tcdl.onclick = function (){
    if(confirm("确定退出登录？")) {
        localStorage.removeItem("Uname");
        localStorage.removeItem("Upassword");
        localStorage.removeItem("Uid");
        
        location.reload()
    }
}



function findPosition( oElement )
{
  var x2 = 0;
  var y2 = 0;
  var width = oElement.offsetWidth;
  var height = oElement.offsetHeight;
  // alert(width + "=" + height);
  if( typeof( oElement.offsetParent ) != 'undefined' )
  {
    for( var posX = 0, posY = 0; oElement; oElement = oElement.offsetParent )
    {
      posX += oElement.offsetLeft;
      posY += oElement.offsetTop;     
    }
    x2 = posX + width;
    y2 = posY + height;
    return [ posX, posY ,x2, y2];
   
    } else{
      x2 = oElement.x + width;
      y2 = oElement.y + height;
      return [ oElement.x, oElement.y, x2, y2, width, height];
  }
}

var a2 = document.getElementsByClassName("a2")[0]
var canhei = (findPosition(a2)[1] - findPosition(a1)[3]) / 1.2
tpzs.height = canhei

load2()
load3()
load4()
load1()
