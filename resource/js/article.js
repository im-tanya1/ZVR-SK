    for (var i = 2; i <= 6; i++) {
        $("#page" + i).hide()
    }
    
    function renderArticle2(optss) {
        if (!+optss.el[5]) {
            return {
                dom: null,
                page: 6
            };
        }
        
        const newArticle = document.createElement("div")
        newArticle.class = "artle"
        newArticle.innerHTML = `
            <article class="interval"></article>
            <div id="w${optss.id}" class="wz">
            <div class="wzinfo">
            <img id="i1${optss.id}" class="hhed" src="/resource/icons/loading.gif" alt="" />
            <div class="autherBox">
            <span id="i2${optss.id}" class="auther">加载中...</span><br>
            <span class="dater">${optss.date}</span>
            </div>
            </div>
    
            <div class="wztitle">${optss.title}</div>
            <div class="wznr">${optss.nr}</div><br>
            <div class="wzht">
            <div>
            <img src="./resource/icons/ll.png" alt="">
            <span>${optss.ll}</span>
            </div>
            <div>
            <img src="./resource/icons/hf.png" alt="">
            <span>${optss.hf}</span>
            </div>
    
            <span class="ht">#${optss.id}</span>
            </div><br>
            </div>
        `
        
        return {
            dom: newArticle,
            page: optss.el[5] - 1,
            id: optss.id
        };
    }
    
var renderList = []
function renderArticle(v){
    renderList.push(v)
}
function renderArticle3(){
    // let doms = new Array(6)
    // doms.fill([])
    const doms = [];

    for (let i = 0; i < renderList.length; i++) {
        const p = renderArticle2(renderList[i])
        doms.push(p)
    }
    const domsList = [];
    for (let i = 0; i < 6; i++) {
        domsList[i] = doms.filter((item, index) => {
            if (item.page === 6) {
                return 0;
            }
            
            // console.log("if", i, item)
            if(item.page === i){
                /*
                解决问题的代码
                */
                
                // console.log(true, index)
                // 效率问题：循环筛选数据
                // 筛选成功一条后不可能再次被筛选
                // 但仍然进行了下次筛选
                // 目前数据量小，等有机会解决
                return 1;
            }
            // 1: true, 0: false
            // 不return默认return undefined;
            // 布尔值 false
            // 可以直接return item.page === i
        })
    }
    
    domsList.forEach(i => {
        var k = document.createElement("div")
        var l
        // 使用类似虚拟DOM方法优化性能，提高效率
        try{
            l = document.getElementById(`page${i[0].page + 1}`) 
        }
        catch(err){
            l = document.createElement("div")
            console.log(err)
        }

        i.forEach(j => {
            j.page += 1;
            // const k = document.getElementById(`page${j.page}`) 
            // console.log(k)
            k.appendChild(j.dom)
        })
        l.innerHTML = k.innerHTML
    })
    
    const arts = document.getElementsByClassName("wz")
    for (let i = 0; i < arts.length; i++) {
        arts[i].onclick = function(){
            tzdWZ(arts[i]["id"].substr(1));
        }
    }
    // 这里使用类名循环绑定事件
    // 更好的做法应该是 事件委托
    
    console.log(domsList)
}
    
async function loadHead(list){
    function renderUser(pid, head, name, uid){
        let fjUser = []
        if (fjUser.indexOf(uid) !== -1) {
            $(`#i1${pid}`).attr("src", '/resource/icons/heads.png')
            $(`#i2${pid}`).text("违规用户")
            return;
        }
        // 违规用户
        
        $(`#i1${pid}`).attr("src", head)
        $(`#i2${pid}`).text(name)
    }
    
    let userList = {}
    for (let pid in list) {
        const uid = list[pid];
        //uid 和 pid
        if (userList[uid]) {
            renderUser(pid, userList[uid].head, userList[uid].name, uid);
            continue;
        }
        
        await $.ajax({
            url:"/user/api/get.php",
            data: {
                id: uid
            },
            async: false
        })
        .then((res) => {
            let ress = JSON.parse(res)
            userList[uid] = ress
            renderUser(pid, userList[uid].head, userList[uid].name, uid);
        })
        .catch((e) => {
            console.log("网络错误，请刷新页面")
        })
    }
}
    
var uh = {}
$.ajax({
    url:"/controls/api/get.php"
})
.then((res) => {
    const articles = JSON.parse(res)
    for (let i = 0; i < articles.length; i++) {
        let v = articles[i]
        uh[v.id] = v.autherID
        renderArticle(v)
    }
    renderArticle3()
    loadHead(uh)
})