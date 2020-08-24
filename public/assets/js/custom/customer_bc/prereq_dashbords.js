
function prereq_dashbords(){
    var parts_cond = ["summary","project_details", "use_case_details", "non_monetizable", "qualitative"];
    parts_cond.forEach(part => {
        $("#"+part).removeClass("disabled");
    });

}

