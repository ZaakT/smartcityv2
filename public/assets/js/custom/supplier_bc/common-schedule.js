let inputs = ["#dstart", "#dduration", "#pstart", "#pduration"]


function monthDiff(d1, d2)
{
    month1 = parseInt(d1.split("-")[1]);
    year1 = parseInt(d1.split("-")[0]);

    month2 = parseInt(d2.split("-")[1]);
    year2 = parseInt(d2.split("-")[0]);
    return (year2-year1)*12 + month2-month1;
}

function dateWihtoutDay(date){
    date_exp = date.toDateString().split(' ').slice(1);
    delete date_exp[1];
    return date_exp.join(' ');

}

function updateBar(submitMode = false){
    if(verifForm(submitMode)){
        console.log("remove");
        $("#chart_schedule").removeAttr("hidden");
        var valDDur = parseFloat($("#dduration").val());
        var valPDur = parseFloat($("#pduration").val());
        var valDStart = $("#dstart").val();
        var valPStart = $("#pstart").val();
        lag_prop = monthDiff( valPStart, valDStart)/valPDur * 100;
        dep_prop = valDDur/valPDur * 100;
        run_prop = (valPDur -valDDur- monthDiff(valPStart, valDStart))/valPDur * 100;

        dep_end = new Date(valDStart);
        dep_end.setMonth(dep_end.getMonth()+valDDur);
        $("#run_starttext").html(dateWihtoutDay(dep_end));

        proj_end = new Date(valPStart);
        proj_end.setMonth(dep_end.getMonth()+valPDur);
        $("#project_end_text").html(dateWihtoutDay(proj_end));


        $("#bar_1").css("width", lag_prop + "%");
        $("#proj_start").css("width", lag_prop + "%");
        $("#proj_start_text").html(dateWihtoutDay(new Date(valPStart)));

        $("#bar_2").css("width", dep_prop + "%");
        $("#dep_start").css("width", dep_prop + "%");
        $("#dep_start_text").html(dateWihtoutDay(new Date(valDStart)));

        $("#bar_3").css("width", run_prop + "%");
        $("#run_start").css("width", run_prop/2 + "%");
        $("#project_end").css("width", run_prop/2 + "%");

        return true;
    }else{
        //$("#chart_schedule").setAttribute("hidden", "true"); Pas utile ? 
        return false;
    }
    
}

function verifForm(submitMode){
    clearAlerts();
    var validate_form = true;
    var colored_inputs = [];
    id = 0;

    if(submitMode){
        var test=false
        inputs.forEach(i => {
            if($(i).val() == "") {
                if(!test){
                    addAlert("Some fields are missing.", id);
                    id++;
                    validate_form = false;
                }

                $(i).addClass("bg-warning");
                colored_inputs.push(i);
                test = true;
            } else {
                if(!colored_inputs.includes(i)) {
                    $(i).removeClass("bg-warning");
                }
            }
        });
    }

    var valDDur = $("#dduration").val();
    valDDur = parseFloat(valDDur) ;  
    var valPDur = $("#pduration").val();
    valPDur =  parseFloat(valPDur) ;  
    

    var valDStart = $("#dstart").val();
    var valPStart = $("#pstart").val();
    var diffPD =monthDiff(valPStart, valDStart);

    if(valDDur<1){
        validate_form = false;
        addAlert("Deployment Duration is to small.", id);
        id++;
        $("#dduration").addClass("bg-warning");
        $("#dduration").val()="";
        colored_inputs.push("#dduration");
    }
    if(valPDur<1 ){
        validate_form = false;
        addAlert("Project Duration is to small.", id);
        id++;
        $("#pduration").addClass("bg-warning");
        $("#pduration").val()="";
        colored_inputs.push("#pduration");
    }
    if((valDDur - diffPD >valPDur)){
        validate_form = false;
        addAlert("The Project Deployment can not end after the project.", id);
        id++;
        $("#dduration").addClass("bg-warning");
        $("#dduration").val()="";
        colored_inputs.push("#pduration");
    }

    if(diffPD<0){
        validate_form = false;
        addAlert("Project deployment start date is not valide.", id);
        id++;
        $("#dstart").val()="";
        $("#dstart").addClass("bg-warning");
        colored_inputs.push("#pduration");
    }

    return validate_form;
}

function submitForm(formName){
    //clearAlerts();
    if(verifForm(formName))
        $("#"+formName).submit();
}

function submitForm_debug(formName){
    $("#"+formName).submit();
}

function highlight_db_values() {
    var prefilled = false

    inputs.forEach(i => {
        if($(i).val() != "") {
            $(i).addClass("bg-prefilled");
            prefilled = true
        }
    });
}