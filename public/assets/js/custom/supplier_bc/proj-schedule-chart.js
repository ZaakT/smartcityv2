function update_chart(event) {
    update_all_chart()
    /*
    let debut_projet = new Date(document.querySelector("p#project-start").outerText)
    let fin_projet = new Date(document.querySelector("p#project-end").outerText)
    let duree_projet = Math.round(fin_projet.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)

    if (event.id.startsWith("ucpri")) { //UC Pricing Schedule (3 bars)
        let bar_void = "ucpri_1_bar"
        let bar_poc = "ucpri_2_bar"
        let bar_run = "ucpri_3_bar"

        let transition_void = new Date($("#ucpri_2").val())
        let transition_poc = new Date($("#ucpri_3").val())

        let duree_void = Math.round((Math.round(transition_void.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_poc = Math.round((Math.round(transition_poc.getTime() - transition_void.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_poc.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void).css("width", duree_void + "%")
        $("#" + bar_poc).css("width", duree_poc + "%")
        $("#" + bar_run).css("width", duree_run + "%")
    }/* else if (event.id.startsWith("ucrev")) { //UC Revenues Schedule (4 bars)
        let bar_void = "ucrev_1_bar"
        let bar_lag = "ucrev_2_bar"
        let bar_ramp = "ucrev_3_bar"
        let bar_run = "ucrev_4_bar"

        let transition_void = new Date($("#ucrev_2").val())
        let transition_lag = new Date($("#ucrev_3").val())
        let transition_ramp = new Date($("#ucrev_4").val())


        let duree_void = Math.round((Math.round(transition_void.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_lag = Math.round((Math.round(transition_lag.getTime() - transition_void.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_ramp = Math.round((Math.round(transition_ramp.getTime() - transition_lag.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_ramp.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void).css("width", duree_void + "%")
        $("#" + bar_lag).css("width", duree_lag + "%")
        $("#" + bar_ramp).css("width", duree_ramp + "%")
        $("#" + bar_run).css("width", duree_run + "%")
    }*//*else if (!event.id.endsWith("_1")) { //reste des cas
        let bar = event.id + "_bar";
        let bar_precedente = event.id.split("_")[0] + "_" + (parseInt(event.id.slice(-1)) - 1) + "_bar";

        let date_transition = new Date(event.value);
        var duree_depuis_debut = Math.round((Math.round(date_transition.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        var duree_depuis_fin = Math.round((Math.round(fin_projet.getTime() - date_transition.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar).css("width", duree_depuis_fin + "%")
        $("#" + bar_precedente).css("width", duree_depuis_debut + "%")
    }*/
}



function check_form_debug() {
    $("#supplier_schedule").submit();
}

function dateWihtoutDay(date){
    date_exp = date.toDateString().split(' ').slice(1);
    delete date_exp[1];
    return date_exp.join(' ');

}
function update_all_chart() {
    let debut_projet = new Date(document.querySelector("p#project-start").outerText)
    let fin_projet = new Date(document.querySelector("p#project-end").outerText)
    let duree_projet = Math.round(fin_projet.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)



    




    /*//UC Revenues Schedule (4 bars)
    let bar_void_2 = "ucrev_1_bar"
    let bar_lag = "ucrev_2_bar"
    let bar_ramp = "ucrev_3_bar"
    let bar_run_2 = "ucrev_4_bar"

    let transition_void_2 = new Date($("#ucrev_2").val())
    let transition_lag = new Date($("#ucrev_3").val())
    let transition_ramp = new Date($("#ucrev_4").val())

    if (transition_void_2 && transition_lag && transition_ramp) {
        let duree_void = Math.round((Math.round(transition_void_2.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_lag = Math.round((Math.round(transition_lag.getTime() - transition_void_2.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_ramp = Math.round((Math.round(transition_ramp.getTime() - transition_lag.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        let duree_run = Math.round((Math.round(fin_projet.getTime() - transition_ramp.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

        $("#" + bar_void_2).css("width", duree_void + "%")
        $("#" + bar_lag).css("width", duree_lag + "%")
        $("#" + bar_ramp).css("width", duree_ramp + "%")
        $("#" + bar_run_2).css("width", duree_run + "%")
    }*/
    let bar_void_pricing = "ucpri_1_bar"
    let bar_poc_pricing = "ucpri_2_bar"
    let bar_run_pricing = "ucpri_3_bar"
    let bar_void_fin_pricing = "ucpri_4_bar"

    let bar_void_operation = "ucop_1_bar";
    let bar_deployment_operation = "ucop_2_bar";
    let bar_produ_operation = "ucop_3_bar";
    let bar_void_fin_operation = "ucop_4_bar";

    let deploy_start_operation = new Date($("#ucop_deploy_start").val())
    let uc_end = new Date($("#ucop_uc_end").val())
    //console.log(deploy_start_operation)
    if (deploy_start_operation) {
        var duree_void_operation = Math.round((Math.round(deploy_start_operation.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        var duree_deployment_operation = $("#ucop_deployment_duration").val()*30/ duree_projet * 100;

        $("#" + bar_void_operation).css("width", duree_void_operation + "%")
        if(duree_deployment_operation){
            $("#" + bar_deployment_operation).css("width", duree_deployment_operation + "%")
            var duree_production_operation = Math.round((Math.round(uc_end.getTime() - deploy_start_operation.getTime()) / (1000 * 60 * 60 * 24) - $("#ucop_deployment_duration").val()*30) / duree_projet * 100)
            if(duree_production_operation){
                $("#" + bar_produ_operation).css("width", duree_production_operation + "%")
                $("#" + bar_void_fin_operation).css("width", (100-duree_production_operation-duree_deployment_operation-duree_void_operation) + "%")
                $("#" + bar_void_fin_pricing).css("width", (100-duree_production_operation-duree_deployment_operation-duree_void_operation) + "%")
            }

        }
    }
    var bar_void_p = "proj_1_bar";
    var bar_dep_p= "proj_2_bar"
    var bar_run_p = "proj_3_bar"

    var project_dep_start_p = new Date($("#project_dep_start").val())
    var project_dep_end_p = new Date($("#project_dep_end").val())


    var duree_void_p = Math.round((Math.round(project_dep_start_p.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
    var duree_dep_p = Math.round((Math.round(project_dep_end_p.getTime() - project_dep_start_p.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
    var duree_run_p = Math.round((Math.round(fin_projet.getTime() - project_dep_end_p.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)

    $("#" + bar_void_p).css("width", duree_void_p + "%")
    $("#" + bar_dep_p).css("width", duree_dep_p + "%")
    $("#" + bar_run_p).css("width", duree_run_p + "%")


    
    //UC Pricing Schedule (3 bars)

    let poc_start = new Date($("#ucpri_pricing_start").val())
    var poc_duration = $("#ucpri_poc_duration").val()
    if(poc_start){
        var duree_void_pricing = Math.round((Math.round(poc_start.getTime() - debut_projet.getTime()) / (1000 * 60 * 60 * 24)) / duree_projet * 100)
        $("#" + bar_void_pricing).css("width", duree_void_pricing + "%")

        if (poc_duration) {
            let duree_poc = Math.round(poc_duration*30 / duree_projet * 100)
            $("#" + bar_poc_pricing).css("width", duree_poc + "%")

            let duree_run = 100 - (100-duree_production_operation-duree_deployment_operation-duree_void_operation) - duree_void_pricing - duree_poc
    
            $("#" + bar_run_pricing).css("width", duree_run + "%")
        }
    }



}