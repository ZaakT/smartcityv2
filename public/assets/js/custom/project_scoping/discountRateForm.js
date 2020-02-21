function checkRate(){
    var val = $("#discount_rate_input").val();
    val = val=="" ? 0. : parseFloat(val);
    if(val <= 0.){
        $("#discount_rate_input").css("background","salmon");
        $("#discount_rate_input").val("");
        return false;
    } else {
        //$("#discount_rate_input").val(val);
        $("#discount_rate_input").css("background","#C3E6CB");
        return true;
    }
}

checkRate();