
function prereq_dashbords(check){
    var parts_cond = ["summary","project_details", "use_case_details", "non_monetizable", "qualitative"];
    if(check){
        parts_cond.forEach(part => {
            //console.log(part);
            $("#"+part).removeClass("disabled");
        });
    }
}
