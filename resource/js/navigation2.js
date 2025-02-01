for (var j = 1; j <= 4; j++) {
    document.getElementById('fun' + j).style.display = 'none'
}
fun1.style.display = 'block'
$("#Top-navigation-bar li").first().attr("class","active")
$("#Top-navigation-bar li").first().siblings().attr("class","other")
$("#Top-navigation-bar li").click(e => {
    $("#Top-navigation-bar .active").attr("class","other")
    $(e.target).attr("class","active")
    
    const pageClick = $(e.target).index() + 1
    $("#fun" + pageClick).show()
    for (var i = 1; i <= 4; i++) {
        if (i !=pageClick) {
            $("#fun" + i).hide()
        }
    }
})