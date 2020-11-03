
function prereq_project_initialisation(nb){
    var parts_cond = ["project", "perimeter1","scope1"];
    for (let index = 0; index <= nb; index++) {
        $("#"+parts_cond[index]).removeClass("disabled");
    }
}

