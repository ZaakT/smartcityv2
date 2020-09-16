let inputs = ["#dstart", "#dduration", "#pstart", "#pduration"]


function mounthDiff(d1, d2)
{
    mounth1 = parseInt(d1.split("-")[1]);
    year1 = parseInt(d1.split("-")[0]);

    mounth2 = parseInt(d2.split("-")[1]);
    year2 = parseInt(d2.split("-")[0]);
    return (year2-year1)*12 + mounth2-mounth1;
}
function submitForm(formName){
    var validate_form = true;
    var colored_inputs = []

    inputs.forEach(i => {
        if($(i).val() == "") {
            $('.alert').addClass("show");
            
            $('.alert').text("Some fields are missing.");
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
    var diffPD =mounthDiff(valPStart, valDStart);

    if(valDDur<1){
        validate_form = false;
        $('.alert').addClass("show");
        $('.alert').text("Deployment Duration is to small.");
        $("#dduration").addClass("bg-warning");
        colored_inputs.push("#dduration");
    }
    if(valPDur<1 ){
        validate_form = false;
        $('.alert').addClass("show");
        $('.alert').text("Project Duration is to small.");
        $("#pduration").addClass("bg-warning");
        colored_inputs.push("#pduration");
    }
    if((valDDur - diffPD >valPDur)){
        validate_form = false;
        $('.alert').addClass("show");
        $('.alert').text("The Project Deployment can not end after the project.");
        $("#dduration").addClass("bg-warning");
        colored_inputs.push("#pduration");
    }

    if(diffPD<0){
        validate_form = false;
        $('.alert').addClass("show");
        $('.alert').text("Project deployment start date is not valide.");
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