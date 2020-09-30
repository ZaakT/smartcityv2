function déverouiller_sidebar() {
    var sidebar_elem = $("a.active").first()
    while(sidebar_elem.hasClass("disabled")) {
        sidebar_elem.removeClass("disabled")
        sidebar_elem = sidebar_elem.prev()
    }
}

function prereq_ipc_sup(){
    var parts_cond = ["project_selection","use_case_cb","schedule","equipment_revenues","deployment_revenues","operating_revenues", "opex", "capex","deployment_costs", "summary" ];
    parts_cond.forEach(part => {
        $("#"+part).removeClass("disabled");
    });
    
}
