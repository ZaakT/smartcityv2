
function comparaison(d1, d2, message, idAlert, changed_buttons, validate_form, btn){
    
    if(monthDiff(d1, d2)<0){
        //console.log("bad date");
        addAlert(message, idAlert);
        //console.log("before :"+idAlert);
        idAlert++;
        //console.log("after :"+idAlert);
        validate_form = false;

        $(btn).removeClass("btn-dark")
        $(btn).addClass("btn-warning")
        if (!changed_buttons.includes(btn)) {
            changed_buttons.push(btn)
        }
        changed_buttons.push(btn)
    }
    
    //console.log("before return  :"+idAlert);
    return idAlert, changed_buttons, validate_form;
}

function check_form() {
    clearAlerts();
    var startdate = $("#date-start").text();
    var enddate = $("#date-end").text();
    var projDepStart = $("#project_dep_start").val();
    var projDepEnd = $("#project_dep_end").val();
    var uc_dep_duration = $("#ucop_deployment_duration").val();
    var validate_form = true
    let inputs = ["#ucop_deploy_start", "#ucop_deployment_duration", "#ucop_uc_end", "#ucpri_pricing_start", "#ucpri_poc_duration"]
    let names = {"#ucop_deploy_start":"UC Deployment Start", "#ucop_deployment_duration":"UC Deployment Duration", "#ucop_uc_end":"UC End", "#ucpri_pricing_start":"Start of pricing", "#ucpri_poc_duration":"POC duration"};
    let changed_buttons = [];
    var idAlert = 0;
    inputs.forEach(i => {
        let btn = i.substring(0, i.indexOf("_"))
        console.log("i :" +i);
        if ($(i).val() == "") {
            addAlert('"'+names[i]+'"'+" is missing.", idAlert);
            idAlert++;
            validate_form = false;

            $(btn).removeClass("btn-dark")
            $(btn).addClass("btn-warning")
            changed_buttons.push(btn)
        }
        else{
            if(!i.includes("duration")){
                //console.log(i+ " :" + $(i).val())
                if(monthDiff($(i).val(), projDepStart)>0){
                    addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before the project's deployment ("+projDepStart+").", idAlert);
                    idAlert++;
                    validate_form = false;
        
                    $(btn).removeClass("btn-dark")
                    $(btn).addClass("btn-warning")
                    changed_buttons.push(btn)
                }

            }

            if(monthDiff($(i).val(), enddate)<0){
                $('.alert').addClass("show");
                addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not end after the project ("+enddate+").", idAlert);
                idAlert++;
                validate_form = false;

                $(btn).removeClass("btn-dark")
                $(btn).addClass("btn-warning")
                changed_buttons.push(btn)
            }
            if(i=="#ucop_deploy_start"){        
                if(monthDiff($(i).val(), projDepEnd)<0){
                    addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin after the end of the project deployment "+"("+projDepEnd+").", idAlert);
                    idAlert++;
                    validate_form = false;

                    $(btn).removeClass("btn-dark")
                    $(btn).addClass("btn-warning")

                    changed_buttons.push(btn)
                }
                if(monthDiff($(i).val(), projDepEnd)<uc_dep_duration){
                    addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not end after the end of the project deployment "+"("+projDepEnd+").", idAlert);
                    idAlert++;
                    validate_form = false;

                    $(btn).removeClass("btn-dark")
                    $(btn).addClass("btn-warning")

                    changed_buttons.push(btn)
                } 
            }else if(i=="#ucop_uc_end"){            
                if(monthDiff($(i).val(), $("#ucop_deploy_start").val())>uc_dep_duration){
                    addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before the end of "+'"'+names["#ucop_deploy_start"]+'"'+ " ("+$("#ucop_deploy_start").val()+").", idAlert);
                    idAlert++;
                    validate_form = false;

                    $(btn).removeClass("btn-dark")
                    $(btn).addClass("btn-warning")

                    changed_buttons.push(btn)
                }

            }else if(i=="#ucpri_pricing_start"){
                console.log(monthDiff($(i).val(), $("#ucop_deploy_start").val()));
                if(monthDiff($(i).val(), $("#ucop_deploy_start").val())>0){
                    addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before "+'"'+names["#ucop_deploy_start"]+'"'+ " ("+$("#ucop_deploy_start").val()+").", idAlert);
                    idAlert++;
                    validate_form = false;

                    $(btn).removeClass("btn-dark")
                    $(btn).addClass("btn-warning")

                    changed_buttons.push(btn)
                } 

            }else if(i=="#ucpri_poc_duration"){
                console.log("wesh !")
                console.log(monthDiff($("#ucop_uc_end").val(), $("#ucpri_pricing_start").val()) +" > " + $(i).val())
                if(monthDiff($("#ucop_uc_end").val(), $("#ucpri_pricing_start").val())>$(i).val()){
                    addAlert("The POC can't end after the UC (" +$("#ucop_uc_end").val()+").", idAlert);
                    idAlert++;
                    validate_form = false;

                    $(btn).removeClass("btn-dark")
                    $(btn).addClass("btn-warning")

                    changed_buttons.push(btn)
                } 

            }
            if (!changed_buttons.includes(btn)) {
                $(btn).removeClass("btn-warning")
                $(btn).addClass("btn-dark")
            }

        }
    })

    if (validate_form){
        $("#supplier_schedule").submit();
    }
}