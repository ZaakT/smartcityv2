
function prereq_ipc(nb=0){
    var parts_cond0 = ["use_case_selection", "schedule"];
    var parts_cond1 = ["capex", "cash_in", "cash_out","equipment_revenues","deployment_revenues", "deployment_costs","operating_revenues", "opex", "deal_criteria"];
    parts_cond0.forEach(part => {
        $("#"+part).removeClass("disabled");
    });
    if(nb>0){
        parts_cond1.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }

    

}

function selectCashIn_Out(type){
    if (type == "in"){
        $("#cash_in").addClass("active");
    }else if(type == "out"){
        $("#cash_out").addClass("active");
    }

}

