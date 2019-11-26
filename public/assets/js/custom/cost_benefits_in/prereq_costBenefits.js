
function prereq_CostBenefits1(check){
    var parts_cond = ["use_case_cb"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_CostBenefits2(check){
    var parts_cond = ["capex","implem","opex","revenues","cashreleasing","widercash"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

