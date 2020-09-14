let inputs = ["#dstart", "#dduration", "#pstart", "#pduration"]

function submitForm(formName){
    var validate_form = true;
    var colored_inputs = []

    inputs.forEach(i => {
        if($(i).val() == "") {
            $('.alert').addClass("show");
            validate_form = false;

            $(i).addClass("bg-warning");
            colored_inputs.push(i);
        } else {
            if(!colored_inputs.includes(i)) {
                $(i).removeClass("bg-warning");
            }
        }
    });

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