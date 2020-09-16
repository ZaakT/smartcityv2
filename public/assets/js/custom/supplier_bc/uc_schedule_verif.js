
function comparaison(d1, d2, message, idAlert, changed_buttons, validate_form, btn){
    
    if(mounthDiff(d1, d2)<0){
        console.log("bad date");
        addAlert(message, idAlert);
        console.log("before :"+idAlert);
        idAlert++;
        console.log("after :"+idAlert);
        validate_form = false;

        $(btn).removeClass("btn-dark")
        $(btn).addClass("btn-warning")
        if (!changed_buttons.includes(btn)) {
            changed_buttons.push(btn)
        }
        changed_buttons.push(btn)
    }
    
    console.log("before return  :"+idAlert);
    return idAlert, changed_buttons, validate_form;
}

function check_form() {
    clearAlerts();
    var startdate = $("#date-start").text();
    var enddate = $("#date-end").text();
    var validate_form = true
    let inputs = ["#ucop_2", "#ucpri_2", "#ucpri_3", "#ucrev_2", "#ucrev_3", "#ucrev_4"]
    let names = {"#ucop_2":"Deployment > Production", "#ucpri_2":"POC Start", "#ucpri_3":"POC > Run", "#ucrev_2":"Lag Start", "#ucrev_3":"Lag > Ramp-up", "#ucrev_4":"Ramp-up > Run"};
    let changed_buttons = [];
    var idAlert = 0;
    inputs.forEach(i => {
        let btn = i.substring(0, i.indexOf("_"))
        if ($(i).val() == "") {
            addAlert('"'+names[i]+'"'+" is missing.", idAlert);
            idAlert++;
            validate_form = false;

            $(btn).removeClass("btn-dark")
            $(btn).addClass("btn-warning")
            changed_buttons.push(btn)
        } 
        if(mounthDiff($(i).val(), startdate)>0){
            addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before the project ("+startdate+").", idAlert);
            idAlert++;
            validate_form = false;

            $(btn).removeClass("btn-dark")
            $(btn).addClass("btn-warning")
            changed_buttons.push(btn)
        }

        if(mounthDiff($(i).val(), enddate)<0){
            $('.alert').addClass("show");
            addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not end after the project ("+enddate+").", idAlert);
            idAlert++;
            validate_form = false;

            $(btn).removeClass("btn-dark")
            $(btn).addClass("btn-warning")
            changed_buttons.push(btn)
        }
        if(i=="#ucpri_2"){        
            if(mounthDiff($(i).val(), $("#ucop_2").val())>0){
                addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before "+'"'+names["#ucop_2"]+'"'+ " ("+$("#ucop_2").val()+").", idAlert);
                idAlert++;
                validate_form = false;

                $(btn).removeClass("btn-dark")
                $(btn).addClass("btn-warning")

                changed_buttons.push(btn)
            }
            if(mounthDiff($(i).val(), $("#ucpri_3").val())<0){
                addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not end after "+'"'+names["#ucpri_3"]+'"'+ " ("+$("#ucpri_3").val()+").", idAlert);
                idAlert++;
                validate_form = false;

                $(btn).removeClass("btn-dark")
                $(btn).addClass("btn-warning")

                changed_buttons.push(btn)
            }

        }else if(i=="#ucrev_2"){            
            if(mounthDiff($(i).val(), $("#ucop_2").val())>0){
                addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before "+'"'+names["#ucop_2"]+'"'+ " ("+$("#ucop_2").val()+").", idAlert);
                idAlert++;
                validate_form = false;

                $(btn).removeClass("btn-dark")
                $(btn).addClass("btn-warning")

                changed_buttons.push(btn)
            }

        }else if(i=="ucrev_3"){
            if(mounthDiff($(i).val(), $("#ucrev_2").val())>0){
                addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not begin before "+'"'+names["#ucrev_2"]+'"'+ " ("+$("#ucrev_2").val()+").", idAlert);
                idAlert++;
                validate_form = false;

                $(btn).removeClass("btn-dark")
                $(btn).addClass("btn-warning")

                changed_buttons.push(btn)
            }            
            if(mounthDiff($(i).val(), $("#ucrev_4").val())<0){
                addAlert('"'+names[i]+'"'+" ("+$(i).val()+") can not end after "+'"'+names["#ucrev_4"]+'"'+ " ("+$("#ucrev_4").val()+").", idAlert);
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

    })

    if (validate_form)
        $("#supplier_schedule").submit();
}