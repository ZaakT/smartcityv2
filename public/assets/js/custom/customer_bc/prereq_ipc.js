
function prereq_ipc(nb=0){
    var parts_cond0 = ["use_case_selection", "schedule"];
    var parts_cond1 = ["capex","equipment_revenues","deployment_revenues", "deployment_costs","operating_revenues", "opex", "deal_criteria"];
    console.log("coucou");
    parts_cond0.forEach(part => {
        $("#"+part).removeClass("disabled");
    });
    if(nb>0){
        parts_cond1.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }

}