


function prereq_CostBenefits1(check){
    var parts_cond = ["use_case_cb","summary"];
    if(check){
        parts_cond.forEach(part => {
            console.log(part);
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_CostBenefits2(check,hasRevSchedule){
    if(hasRevSchedule){
        var parts_cond = ["capex","implem", "deployment_costs","opex","revenues", "revenuesProtection","cashreleasing","widercash","quantifiable","noncash","risks","summary"];
    } else {
        var parts_cond = ["capex","implem", "deployment_costs","opex", "revenuesProtection","cashreleasing","widercash","quantifiable","noncash","risks","summary"];
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
    console.log("we check :"+part);
    $("#"+part+"-item").removeClass("d-none");
}


function displayGuideline() {
    var classes = $('#guideline_button').classes();
    if (classes.includes("active")) {
        $('#guideline_button').removeClass("active");
        console.log($('#guideline_button').classes());
        $('#body').removeClass('col-8');
        $('#body').addClass('col-12');    
        $('#guideline').hide();
    } else {
        $('#guideline_button').addClass("active");
        console.log($('#guideline_button').classes());
        $('#guideline').show();
        $('#body').removeClass('col-12');
        $('#body').addClass('col-8');
        
    }
}