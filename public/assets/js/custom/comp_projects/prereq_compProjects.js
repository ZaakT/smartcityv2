function prereq_compProjects(check){
    var parts_cond = ["summary","invest","op","cash_flows","non_quant","finsoc_comp"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}
