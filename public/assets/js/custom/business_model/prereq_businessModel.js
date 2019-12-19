
function prereq_businessModel(check){
    var parts_cond = ["pref","reco"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}
