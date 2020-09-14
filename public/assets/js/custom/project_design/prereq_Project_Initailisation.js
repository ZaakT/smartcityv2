
function prereq_project_initialisation(nb){
    var parts_cond = ["project","scope1", "perimeter1"];
    for (let index = 0; index <= nb; index++) {
        $("#"+parts_cond[index]).removeClass("disabled");
    }
}

