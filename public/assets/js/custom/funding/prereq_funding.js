
function prereq_funding(check){
    var parts_cond = ["work_cap_req","funding_sources","benef"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}
