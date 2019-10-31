
function prereq_ProjectDesign1(check){
    var parts_cond = ["measures","criteria","geography"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectDesign2(check){
    var parts_cond = ["use_case"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectDesign3(check){
    var parts_cond = ["rating"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectDesign4(check){
    var parts_cond = ["scoring"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectDesign5(check){
    var parts_cond = ["global_score"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}
