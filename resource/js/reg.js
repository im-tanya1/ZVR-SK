weibo.onclick = () => {
    window.location.href = "https://api.uomg.com/api/login.weibo?method=login&callback=" + location.protocol + "://" + location.host + location.pathname
}
wechat.onclick
qq.onclick = () => {
    window.location.href = "https://api.uomg.com/api/login.qq?method=login&callback=" + location.protocol + "://" + location.host + location.pathname
}
baidu.onclick = () => {
    window.location.href = "https://api.uomg.com/api/login.baidu?method=login&callback=" + location.protocol + "://" + location.host + location.pathname
}


var RegIng = false
submitiess.onclick = function () {
    if (RegIng) {
        alert("你已经注册过了！")
        return;
    }
    const apassword = $('#ipassword').val()
    const apassword2 = $('#ipassword2').val()
    if (apassword != apassword2) {
        alert("两次密码不一致")
        return 0;
    }
    const aname = $('#iname').val()
    if (apassword == "" || aname == "") {
        alert("用户名和密码不能为空")
        return 0;
    }
    function regg(n,p){
        $.ajax({
            url:"/user/api/register.php",
            method: "post",
            data: {
                name: n,
                password: md5(p),
                method: 'add',
                canvas: getCanvasFingerprint()
            },
            success: function(ress){
                let res = JSON.parse(ress)
                if(res.code == 200){
                    alert("注册成功")
                    localStorage.setItem("Uname", n);
                    localStorage.setItem("Upassword", md5(p));
                    localStorage.setItem("Ucanvas", getCanvasFingerprint());
                    
                    testUser()
                }else{
                    alert("用户注册错误，请稍后重试")
                }
            }
        })
    }
    $.ajax({
        url:"/user/api/get2.php",
        data: {
            name: aname
        },
        success: function(ress){
            let res = JSON.parse(ress)
            if(res.code != 200){
                RegIng = true
                regg(aname, apassword)
            }else{
                alert("该昵称已被占用")
            }
        }
    })
}