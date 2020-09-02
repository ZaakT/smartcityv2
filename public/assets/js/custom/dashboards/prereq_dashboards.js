
function prereq_dashboards(check){
    console.log("coucou");
    var parts_cond = ["global_dashboard", "cost_benefits","cost_benefits_uc","cost_benefits_all","budget","budget_uc","budget_all","bankability","financing","project_dashboard"];
    if(check){
        parts_cond.forEach(part => {
            $("#"+part).removeClass("disabled");
        });
    }
}

prereq_dashboards();
