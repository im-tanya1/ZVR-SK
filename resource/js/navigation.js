$("#Top-navigation-bar li").first().attr("class","active")
$("#Top-navigation-bar li").first().siblings().attr("class","other")
$("#Top-navigation-bar li").click(e => {
    $("#Top-navigation-bar .active").attr("class","other")
    $(e.target).attr("class","active")
    
    const pageClick = $(e.target).index() + 1
    $("#page" + pageClick).show()
    for (var i = 1; i <= 6; i++) {
        if (i !=pageClick) {
            $("#page" + i).hide()
        }
    }
})