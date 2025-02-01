$('#ssubmit').click(() => {})

setInterval(() => {
    setTimeout(function() {
        znz.innerText = '.'
    }, 500);
    setTimeout(function() {
        znz.innerText = '..'
    }, 1000);
    setTimeout(function() {
        znz.innerText = '...'
    }, 1500);
    setTimeout(function() {
        znz.innerText = ''
    }, 2000);
}, 2000)

function arrange(source) {
    var t;
    var ta;
    var r = [];

    source.forEach(function(v) {
        if (t === v) {
            ta.push(t);
            t++;
            return;
        }

        ta = [v];
        t = v + 1;
        r.push(ta);
    });

    return r;
}


function wjcjc(str){
    return new Promise((resolve, reject) => {
        let st = str.split("")
        let wjz = ["操", "逼", "日"];
        let wjc = ["你爸", "你妈了个逼", "你妈", "你他妈", "你妈了个", "杨苗", "李中峰", "修敏", "蚕蛹", "长友", "乐子", "脑瘫", "重开", "垃圾人士", "操你妈", "我操", "我操你", "操你", "我操你妈", "李忠峰", "李平峰", "我日你妈", "日你妈", "日你", "我日你", "日你妈", "傻逼", "傻X", "傻波一", "网赌", "读博", "月抛", "约炮", "傻13", "傻B", "傻币", "傻哔", "傻笔", "傻比", "傻臂", "傻必", "色情网站", "同城约炮", "吸毒", "K粉", "白粉", "海洛因", "鸦片", "大麻", "鲨臂", "啥比", "沙币", "建议重开", "牛子", "懒子", "鸡吧", "寄吧", "几把", "一把石手", "阿米诺斯", "SB", "CNM", "LZ", "DCY", "LXM", "YM", "LZF", "NT", "sb", "Sb", "sB", "cnm", "Cnm", "CNm", "CnM", "cNm", "cnM", "cNM", "cnM"];
        
        console.log("单字匹配开始")
        let fil1 = wjz.filter(item => {
            console.log(item, st.indexOf(item) !== -1)
            return st.indexOf(item) !== -1
        })
        console.log(fil1)
        
        console.log("——————————————————————————")
        console.log("词组匹配开始")
        let fil2 = wjc.filter(item => {
            let s = item.split("")
            // Array s, st
            console.log(item, "开始匹配")
            let s2 = s.map(v => {
                return st.indexOf(v);
            })
            if(s2.includes(-1)){
                console.log(item, "第一次判断时排除")
                console.log("------------------")
                return false;
            }
            
            let s3 = arrange(s2)["length"] === 1
            console.log(s2, s3)
            if(!s3){
                console.log(item, "第二次判断时排除")
                console.log("------------------")
                return false;
            }
            
            console.log(item, "匹配成功")
            console.log("------------------")
            return true;
        })
        console.log(fil2)
        
        if (!fil1.length && !fil2.length) {
            resolve({
                wj: false,
                data: {
                    str
                }
            })
        }
        else{
            resolve({
                wj: true,
                data: {
                    str
                },
                fil1,
                fil2
            })
        }
    })
}

const pinfo = document.getElementById("pinfo")
const ael = document.getElementById("aaa")
ael.addEventListener("click", () => {
    const ae = document.createElement("a")
    const aid = prompt("请输入文章ID(文章右下角#后为文章ID)，引用的文章一旦确定，更改文字不能改变跳转的文章")
    if (aid) {
        ae.innerText = `超链接(${aid})`
        ae.style.color = "var(--themeColor)"
        ae.classList.add('tw');
        ae.contenteditable = "false"
        ae.id = `tw${aid}`
        pinfo.appendChild(ae)
    }
})
ssubmit.onclick = function() {
    var title = ptitle.innerText
    var content2 = pinfo.innerHTML
    content2 = content2.replaceAll('"', "'")
    // 把双引号替换为单引号

    const address = '哈尔滨'
    const pages = Number($("#fbdn option:selected")[0].value)
    console.log(pages)
    if (title.length > 20) {
        alert('标题最多为20字符')
        return 0;
    }
    if (title === '' || content2 === '') {
        alert('标题或正文不能为空')
        return 0;
    }
    
    
    wjcjc(content2)
    .then(content3 => {
        // 违禁词检测
        var content, wg
        if (content3.wj) {
            content = content3.data.str;
            wg = true;
        }
        else{
            content = content3.data.str;
            wg = false;
        }
        
        const name = localStorage.getItem("Uname");
        ziz.style.display = 'block'
        $.ajax({
            method: 'get',
            url: '/user/api/get2.php',
            data: {
                name
            }
        })
        .then((ress) => {
            res = JSON.parse(ress)
            const uid = res.uid
            
            $.ajax({
                method: 'post',
                url: '/controls/api/add.php',
                data: {
                    title: title,
                    content: content,
                    address: address,
                    elmi: pages,
                    id: uid,
                    wg
                }
            })
            .then((ress) => {
                res = JSON.parse(ress)
                if (res.code == 200) {
                    if (confirm('文章发布成功，是否跳转查看')) {
                        tzdWZ(res.id)
                    }
                    ptitle.value = '标题'
                    pinfo.innerHTML = '正文'
                } else {
                    alert('发布失败')
                }
                ziz.style.display = 'none'
            })
            .catch(err => {
                alert("无法上传文章，请检查网络")
                ziz.style.display = 'none'
            })
        })
        .catch(err => {
            alert("无法上传文章，请检查网络")
            ziz.style.display = 'none'
        })
    })
    .catch(err => {
        alert("无法上传文章，稍后重试")
        ziz.style.display = 'none'
    })
}

bbb.onclick = function() {
    const elii = document.createElement('b')
    elii.innerText = '加粗字体'
    pinfo.appendChild(elii)
}
iii.onclick = function() {
    const elii = document.createElement('i')
    elii.innerText = '倾斜字体'
    pinfo.appendChild(elii)
}
sss.onclick = function() {
    const elii = document.createElement('s')
    elii.innerText = '删除字体'
    pinfo.appendChild(elii)
}



var files;
var f = document.getElementById('file')
f.addEventListener("change", e => {
    /*
    var reader = new FileReader();
    reader.onload = (function (file) {
        return function (e) {
            files = e.target.result;
            console.info(e.target.result);
            //这个就是base64的数据
        };
    })(e.target.files[0]);
    reader.readAsDataURL(e.target.files[0]);
    */
    
})

window.ooo = false;
function upload() {
    var formData = new FormData(); 
    formData.append('file', $('#file')[0].files[0]);
    
    if (window.ooo === true) {
        alert("文件正在上传中，请不要重复上传")
        return 0;
    }
    window.ooo = true;
    alert('文件开始上传！')
    $.ajax({
        // url:'/resource/imgbed/1.php',
        url: '//api.xinyew.cn/api/360tc',
        type: 'post',
        cache: false,
        data: formData,
        processData: false, 
        contentType: false
    })
    .then((ress) => {
        var res
        try {
            res = JSON.parse(ress)
        } catch (e) {
            res = ress
        }
        if (res.errno != 0) {
            window.ooo = false;
            alert("文件上传失败，请稍后重试")
            return 0;
        }
        $.ajax({
            url: '/resource/imgbed/2.php',
            type: 'post',
            data: {
                url: res.data.url,
                uid: localStorage.getItem("userId")
            }
        })
        .then((res2) => {
            if (JSON.parse(res2).code != 200) {
                return;
            }
            var images = document.createElement('img')
            images.src = res.data.url
            images.style.width = '100%'
            window.imagesr = images.outerHTML.replaceAll('"', "'")
            images = $(images.outerHTML.replaceAll('"', "'"))[0];
            pinfo.appendChild(images)
            window.ooo = false
        })
    })
    .catch((err) => {
        alert("网络错误，请稍后重试")
        window.ooo = false
    })
}
