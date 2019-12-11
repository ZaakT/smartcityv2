
function prereq_dashboards(check){
    var parts_cond = ["cost_benefits_uc","cost_benefits_all","budget_uc","budget_all","bankability","financing","project_dashboard"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}
