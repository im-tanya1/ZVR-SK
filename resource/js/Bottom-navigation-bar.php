<?php
    $sea = $_SERVER['QUERY_STRING'];
    echo '
    $("body").css({
        margin: 0,
        padding: 0
    })
    
    window.togglePage = function(url){
        if (location.pathname != url) {
            skipWeb(url)
        }
    }
    var iiii = document.createElement("div")
    $(iiii).css({
        backgroundColor: "var(--backgroundColor)",
        height: "7vh"
    })
    document.body.appendChild(iiii)

    window.pageOne = "/"
    window.pageTwo = "/chat/index.html"
    window.pageThree = "/controls/add/index.html"
    window.pageFour = "/others/discover/index.html"
    window.pageFive = "/user/mine/index.html"
    var navigation = document.createElement("div")
    $(navigation).html(`
      <li onclick="togglePage(pageOne)">首页</li>
      <li onclick="togglePage(pageTwo)">消息</li>
      <li onclick="togglePage(pageThree)"><div align="center">
        +
      </div></li>
      <li onclick="togglePage(pageFour)">发现</li>
      <li onclick="togglePage(pageFive)">我的</li>
    `)

    $(navigation).css({
        zIndex: 3,
        backgroundColor: "var(--whiteColor)",
        listStyleType: "none",
        width: "100%",
        height: "7vh",
        position: "fixed",
        left: "0px",
        bottom: "0px",
        boxShadow: "0px 0px 1px grey",
    })
    $(navigation).children().css({
        width: "20%",
        float: "left",
        textAlign: "center",
        backgroundColor: "var(--whiteColor)",
        color: "var(--blackColor)",
        lineHeight: "7vh",
        fontSize: "2.2vh"
    })
    $(navigation).children().eq('.$sea.').css({
        width: "20%",
        float: "left",
        textAlign: "center",
        backgroundColor: "var(--whiteColor)",
        color: "var(--themeColor)",
        lineHeight: "7vh",
        fontSize: "2.2vh"
    })
    $(navigation).children().eq(2).css({
        width: "20%",
        float: "left",
        textAlign: "center",
        backgroundColor: "var(--whiteColor)",
        lineHeight: "7vh",
        fontSize: "20px"
    })
    $(navigation).children().eq(2).children().css({
        position: "relative",
        width: "5.5vh",
        left: "calc(50% - 5.5vh / 2)",
        fontSize: "2.75vh",
        lineHeight: "5.5vh",
        marginTop: "0.75vh",
        marginBottom: "0.75vh",
        borderRadius: "1.7vh",
        textAlign: "center",
        backgroundColor: "var(--themeColor)",
        color: "var(--whiteColor)",
    })
    document.body.appendChild(navigation)
    '
?>