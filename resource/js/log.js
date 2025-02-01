submitiess.onclick = function () {
    const apassword = $('#ipassword').val()
    const aname = $('#iname').val()
    if (apassword == "" || aname == "") {
        alert("用户名或密码不能为空")
        return 0;
    }
    function logg(n,p){
        $.ajax({
            url:"/user/api/login.php",
            data: {
                name: n,
                password: md5(p),
                canvas: getCanvasFingerprint()
            },
            success: function(ress){
                let res = JSON.parse(ress)
                switch (res.code) {
                    case '200':
                        localStorage.setItem("Uname", n);
                        localStorage.setItem("Upassword", md5(p));
                        localStorage.setItem("Ucanvas", getCanvasFingerprint());
                        
                        Laccept()
                        break;
                        
                    case '500':
                        alert("账号或密码错误")
                        break;
                        
                    case '501':
                        alert("设备错误")
                        break;
                        
                    default:
                        goLogin()
                        alert("未知状态")
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
            if(res.code == 200){
                logg(aname, apassword)
            }else{
                alert("未查询到该昵称")
            }
        }
    })
}
