function waterI(names) {
    for (let i = 0; i < $("#page1 img").length; i++) {
        let eid = $("#page1 img")[i].id
        if (eid != "headCl" && eid != "notll" && eid != "nothf") {
            waterMarkImg($("#page1 img")[i].src, names)
            .then((base) => {
                $("#page1 img")[i].src = base
            })
            $("#page1 img")[i].src = "/resource/icons/loading.gif"
        }
    }
}

function renderPing(opt = {
    id: 0,
    name: "错误",
    content: "请稍后重试",
    head: "/resource/icons/heads.png"
}){
    const outBox = document.createElement("div");
    outBox.className = "pl";
    outBox.id = `u${opt.id}`;
    
    const inImg = document.createElement("img");
    inImg.src = opt.head;
    inImg.alt = "";
    inImg.style.cssText = "width: 8.5%;float: left;margin: 1.5%";
    outBox.appendChild(inImg);
    
    const inDiv = document.createElement("div")
    inDiv.style.cssText = "width: 88.5%;float: left";
    outBox.appendChild(inDiv);
    
    const inDivSpan1 = document.createElement("span");
    const inDivSpan2 = document.createElement("span");
    inDivSpan1.style.cssText = "font-size: 2.1vh;position: relative;top: 3px";
    inDivSpan2.style.cssText = "font-size: 1.9vh;color: rgb(128, 128, 128);position: relative;top: 1px;"
    inDivSpan1.innerText = opt.name
    inDivSpan2.innerText = opt.content
    
    outBox.appendChild(inDivSpan1)
    outBox.appendChild(document.createElement("br"))
    outBox.appendChild(inDivSpan2)
    
    document.getElementById("plq").appendChild(outBox)
    
    const int = document.createElement("div")
    int.className = "iner"
    document.getElementById("plq").appendChild(int)

    /*
    <div style="float: left;" class="pl" id="u1">
        <img style="width: 8.5%;float: left;margin: 1.5%" src="/resource/icons/heads.png" alt="">
        <div style="width: 88.5%;float: left">
            <span style="font-size: 2.1vh;position: relative;top: 3px">用户名</span><br>
            <span style="font-size: 1.9vh;color: rgb(128, 128, 128);position: relative;top: 1px;">内容</span>
        </div>
    </div>
    */
}

$.ajax({
    method: "get",
    url: "/controls/api/ping2.php",
    data: {
        pid: $(".artle")[0].id
    }
})
.then(res => {
    let rr = JSON.parse(res)
    for (let i = 0; i < rr.length; i++) {
        const item = rr[i]

        $.ajax({
            method: "get",
            url: "/user/api/get.php",
            data: {
                id: item.autherId
            }
        })
        .then(ures => {
            let urr = JSON.parse(ures)
            // console.log(urr)
            renderPing({
                ...urr,
                ...item
            })
        })
    }
})

window.isSubmiting = false;
submirs.onclick = function() {
    if (window.isSubmiting) {
        alert("正在提交中，请稍等")
        return;
    }
    window.isSubmiting = true;
    $.ajax({
        method: "post",
        url: "/controls/api/ping.php",
        data: {
            uid: localStorage.getItem("userId"),
            content: contents.value,
            belong: $(".artle")[0].id
        }
    })
    .then(res => {
        window.isSubmiting = false;
        location.reload()
    })
    .catch(e => {
        window.isSubmiting = false;
    })
}

waterI(hasx.innerText)

try{
    var its = document.getElementsByClassName("tw")
    for (let i = 0; i < its.length; i++) {
        its[i].dataset.tzdId = its[i].id.substr(2)
    }
}
catch(err){
    console.log("本文章没有引用其他文章")
}

const nrz = document.getElementsByClassName("wznr")[0]
const nrt = nrz.innerHTML.length / 300
const nrt2 = Math.ceil(nrt)
const nrt3 = Math.round(nrt)
var nrt4
if (nrt2 !== nrt3 && nrt2 < 5) {
    nrt4 = '小于' +  nrt2
}
else{
    nrt4 = nrt2
}

nrz.innerHTML = `预计阅读时间：${nrt4}分钟</br>` + nrz.innerHTML


const pids = document.getElementsByClassName("artle")[0].id.substr(1)
document.getElementsByClassName("ht")[0].innerText = `#${pids}`




const tws = document.getElementsByClassName("tw")
for (let i = 0; i < tws.length; i++) {
    // tws[i].onclick = tws[i].dataset.onclick
    tws[i].addEventListener("click", e => {
        tzdWZ(tws[i].dataset.tzdId)
    })
}