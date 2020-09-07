function submitForm(formName){
    var validate_form = true
    let inputs = ["#dstart", "#dduration", "#pstart", "#pduration"]
    inputs.forEach(i => {
        if($(i).val() == "") {
            $('.alert').addClass("show");
            validate_form = false;
        }
    })

    if(validate_form)
        $("#"+formName).submit();
}