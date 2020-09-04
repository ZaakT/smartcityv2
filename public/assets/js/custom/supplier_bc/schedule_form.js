function submitForm(formName){
    $("#"+formName).submit();
}

function unlock_sidebar(nb=0){
    var parts_cond0 = ["use_case_selection", "schedule"];
    var parts_cond1 = ["equipment_revenues", "deployment_revenues", "operating_revenues"];
    parts_cond0.forEach(part => {
        $("#"+part).removeClass("disabled");
    });
    if(nb>0){
        parts_cond1.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }

}