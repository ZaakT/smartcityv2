function pwConfirm(){
    if($("#passwordConfirmation").val() != $("#password").val()){
        $("#pwMatch").removeAttr("hidden");
        $("#pwMatch").text("Passwords do not match !");
        $("#pwMatch").addClass("text-danger");
        $("#pwMatch").removeClass("text-success");
    }
    else {
        $("#pwMatch").text("OK !");
        $("#pwMatch").removeClass("text-danger");
        $("#pwMatch").addClass("text-success");
    }
};