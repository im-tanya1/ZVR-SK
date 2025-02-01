var jsv = 0
$("*").css({
    margin: 0,
    padding: 0
})
function renderList(opt){
    jsv++
    if (opt.theme) {
        chatList.innerHTML += `
          <li onclick="inChat(${opt.uid},'${opt.name}')" id="chatI${jsv}" style="height: 55px;padding: 0;" class="iii mdui-list-item mdui-ripple">
            <div class="mdui-list-item-avatar">
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
            <div class="mdui-list-item-avatar">
              <img src="${opt.head}"/>
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
    let res = JSON.parse(ress)
    var resk = Array.from(new Set(res))
    
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
})


function renderChat(me,uId){
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
                    <div class="chat_right_item_1 clearfix">聊天</div>
                        <div class="chat_right_item_2">
                        <div class="chat_right_time clearfix">${item.time}</div>
                        <div class="chat_right_content clearfix">${item.content}</div>
                    </div>
                </div>
                `
            }else{
                chat_middle_item.innerHTML += `
                <div class="chat_left">
                    <div class="chat_left_item_1 clearfix">聊天</div>
                        <div class="chat_left_item_2">
                        <div class="chat_left_time clearfix">${item.time}</div>
                        <div class="chat_left_content clearfix">${item.content}</div>
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
    renderChat(localStorage.getItem("userId"), uId)
}
function outChat(){
    $("#chat_a").animate({
        left:'100%'
    },500);
}