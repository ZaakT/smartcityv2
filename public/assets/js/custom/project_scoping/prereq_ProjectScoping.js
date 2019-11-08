function prereq_ProjectScoping1(check){
    var parts_cond = ["scope","discount_rate"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectScoping2(check){
    var parts_cond = ["perimeter","schedule"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectScoping3(check){
    var parts_cond = ["size"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

function prereq_ProjectScoping4(check){
    var parts_cond = ["volumes"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}