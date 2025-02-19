var jsv = 0
var finishLoad = false
var longPolling = false

$("*").css({
    margin: 0,
    padding: 0
})
function renderList(opt){
    jsv++
    if (opt.theme) {
        chatList.innerHTML += `
          <li onclick="inChat(${opt.uid},'${opt.name}')" id="chatI${jsv}" style="height: 55px;padding: 0;" class="iii mdui-list-item mdui-ripple">
            <div style="margin-left: 1vw" class="mdui-list-item-avatar">
              <img src=${opt.head}/>
            </div>
            <div style="margin-left: 5px" class="mdui-list-item-content">
              <div class="mdui-list-item-title">${opt.name}</div>
              <div style="margin: 0" class="mdui-list-item-text mdui-list-item-one-line">
                <span class="mdui-text-color-theme-text">${opt.theme}</span> - ${opt.content}
              </div>
            </div>
          </li>
        `
    }else{
        chatList.innerHTML += `
          <li onclick="inChat(${opt.uid},'${opt.name}')" id="chatI${jsv}" style="height: 55px;padding: 0;" class="iii mdui-list-item mdui-ripple">
            <div style="margin-left: 1vw" class="mdui-list-item-avatar">
              <img src="${opt.head}"/>
              <div id="hq${opt.uid}" style="display: none;" class="alarm hqs">
               0
              </div>
            </div>
            <div style="margin-left: 5px" class="mdui-list-item-content">
              <div class="mdui-list-item-title">${opt.name}</div>
              <div style="margin: 0;" class="mdui-list-item-text mdui-list-item-one-line">
                ${opt.content}
              </div>
            </div>
          </li>
        `
    }
    
}

function reRender(){
    document.querySelector('#chatList').innerHTML = ""
    renderList({
        name: "平台消息",
        head: "/resource/icons/gf.png",
        content: "恭喜您，完成注册",
        theme: "通知",
        uid: "'gfxx'"
    })
    
    $.ajax({
        url: "/chat/api/chatList.php",
        data: {
            id: localStorage.getItem("userId")
        }
    }).then((ress) => {
        let resk = JSON.parse(ress)
    
        resk.forEach(v => {
            $.ajax({
                url: "/user/api/get.php",
                data: {
                    id: v
                }
            }).then((res) => {
                let ress = JSON.parse(res)
                renderList({
                    name: ress.name,
                    content: "测试文本",
                    head: ress.head,
                    uid: ress.uid
                })
                setTimeout('finishLoad = true', 250)
            })
        })
        var sl = setInterval(() => {
            /*
            if (longPolling) {
                clearInterval(sl)
                return;
            }
            */
            if (finishLoad) {
                longPoll()
                clearInterval(sl)
            }
        }, 130)
    })
}
reRender()

function renderChat(me,uId, uname){
    chat_middle_item.innerHTML = ''
    if (uId === "gfxx") {
        console.log(11)
        return 1;
    }
    $.ajax({
        url: "api/getChat.php",
        data: {
            uo: me,
            ut: uId
        }
    }).then((res) => {
        let resj = JSON.parse(res)
        resj.forEach(item => {
            if (item.from == me) {
                chat_middle_item.innerHTML += `
                <div class="chat_right">
                    <div class="chat_right_item_1 clearfix mdui-ripple">${localStorage.getItem("Uname")}</div>
                        <div class="chat_right_item_2">
                        <div class="chat_right_time clearfix">${/*item.time*/localStorage.getItem("Uname")}</div>
                        <div class="chat_right_content clearfix mdui-ripple">${item.content}</div>
                    </div>
                </div>
                `
            }else{
                chat_middle_item.innerHTML += `
                <div class="chat_left">
                    <div class="chat_left_item_1 clearfix mdui-ripple">${uname}</div>
                        <div class="chat_left_item_2">
                        <div class="chat_left_time clearfix">${/*item.time*/uname}</div>
                        <div class="chat_left_content clearfix mdui-ripple">${item.content}</div>
                    </div>
                </div>
                `
            }
        })
    })
}

function inChat(uId, name){
    ctt.innerText = name
    $("#chat_a").animate({
        left:'0'
    },625);
    renderChat(localStorage.getItem("userId"), uId, name)
}
function outChat(){
    $("#chat_a").animate({
        left:'100%'
    },500);
}

function longPoll() {
    longPolling = true
    $.ajax({
        url: 'api/getNew.php',
        type: 'GET',
        dataType: 'json',
        data: {
            id: localStorage.getItem("userId")
        },
        timeout: 27000, 
        success: function(res) {
            console.log('%c5秒后再次请求...', "background: green;");
            setTimeout(longPoll, 5000);

            const count = {}
            for (let item of res) {
                if (count[item.id]) {
                    count[item.id]++
                }
                else {
                    count[item.id] = 1
                }
            }
            var isFirst = true
            var lists
            var errorList = []
            for (let i in count) {
                const its = document.getElementById('hq' + i)
                if (isFirst) {
                    lists = document.getElementsByClassName("hqs")
                    // console.log(lists)
                    for (let i = 0; i < lists.length; i++) {
                        try {
                            lists[i].innerText = "0"
                        } catch (e) {
                            errorList.push(list[i])
                        }
                    }
                }
                isFirst = false
                try{
                    its.innerText = count[i]
                    its.style.display = "block"
                }
                catch(e){
                    //
                }
            }
            
            errorList.forEach(item => {
                $.ajax({
                    url: "/user/api/get.php",
                    data: {
                        id: item
                    }
                })
                .then((res) => {
                    let ress = JSON.parse(res)
                    renderList({
                        name: ress.name,
                        content: "测试文本",
                        head: ress.head,
                        uid: ress.uid
                    })
                    const its = document.getElementById('hq' + item)
                    its.innerText = count[item]
                })
            })
            
            for (let i = 0; i < lists.length; i++) {
                if(lists[i].innerText === "0"){
                    lists[i].style.display = "none"
                }
            }
            
            // console.log(count)
        },
        error: function(xhr, status) {
            longPoll()
            var lists = document.getElementsByClassName("hqs")
            for (let i = 0; i < lists.length; i++) {
                lists[i].innerText = "0"
                lists[i].style.display = "none"
            }
        }
    });
}

function dd(){
    $.ajax({
        url: './api/post.php', 
        method: 'POST', 
        data: {
            uid: localStorage.getItem("userId"),
            content
        },       
        dataType: 'json'    
    })
    .then((response) => { 
        console.log('请求成功:', response);
    })
    .catch((error) => {  
        console.error('请求失败:', error.status, error.responseText);
    });
}