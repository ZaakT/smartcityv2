function déverouiller_sidebar() {
    console.log("zzzzzz")
    var sidebar_elem = $("a.active").first()
    while(sidebar_elem.hasClass("disabled")) {
        sidebar_elem.removeClass("disabled")
        sidebar_elem = sidebar_elem.prev()
    }
}