
function prereq_CostBenefits1(check){
    var parts_cond = ["use_case_cb","summary"];
    if(check){
        parts_cond.forEach(part => {
            //console.log(part);
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_CostBenefits2(check,hasRevSchedule){
    if(hasRevSchedule){
        var parts_cond = ["capex","implem","opex","revenues","cashreleasing","widercash","noncash","risks"];
    } else {
        var parts_cond = ["capex","implem","opex","cashreleasing","widercash","noncash","risks"];
    }
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

/* function prereq_CostBenefits3(check){
    var parts_cond = ["summary"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
} */

function checkProgress(part){
    $("#"+part+"-item").removeClass("d-none");
}