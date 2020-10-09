let inputs = ["#dstart", "#dduration", "#pstart", "#pduration"]


function monthDiff(d1, d2)
{
    month1 = parseInt(d1.split("-")[1]);
    year1 = parseInt(d1.split("-")[0]);

    month2 = parseInt(d2.split("-")[1]);
    year2 = parseInt(d2.split("-")[0]);
    return (year2-year1)*12 + month2-month1;
}
function submitForm(formName){
    //clearAlerts();
    var validate_form = true;
    var colored_inputs = [];
    id = 0;

    inputs.forEach(i => {
        if($(i).val() == "") {
            addAlert("Some fields are missing.", id);
            id++;
            validate_form = false;

            $(i).addClass("bg-warning");
            colored_inputs.push(i);
        } else {
            if(!colored_inputs.includes(i)) {
                $(i).removeClass("bg-warning");
            }
        }
    });

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
        colored_inputs.push("#dduration");
    }
    if(valPDur<1 ){
        validate_form = false;
        addAlert("Project Duration is to small.", id);
        id++;
        $("#pduration").addClass("bg-warning");
        colored_inputs.push("#pduration");
    }
    if((valDDur - diffPD >valPDur)){
        validate_form = false;
        addAlert("The Project Deployment can not end after the project.", id);
        id++;
        $("#dduration").addClass("bg-warning");
        colored_inputs.push("#pduration");
    }

    if(diffPD<0){
        validate_form = false;
        addAlert("Project deployment start date is not valide.", id);
        id++;
        $("#dstart").addClass("bg-warning");
        colored_inputs.push("#pduration");
    }


    if(validate_form)
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