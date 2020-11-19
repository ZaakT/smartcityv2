function update_chart(event) {
    update_all_chart()
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



    console.log("coucou");
    


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