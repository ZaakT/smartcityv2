function prereq_compFinScen(check){
    var parts_cond = ["fin_summary","cash_flows"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}
