function calcTotWCR(){
    var invest = $('#wcr_input_invest').val() ? parseFloat($('#wcr_input_invest').val()) : 0;
    var op = $('#wcr_input_op').val() ? parseFloat($('#wcr_input_op').val()) : 0;
    //console.log(invest,op);
    $("#wcr_input_tot").text((invest+op).toLocaleString('en-EN',{minimumFractionDigits: 0, maximumFractionDigits: 2}));
}


function checkInputWCR(){
    var ret = true;
    $("#workcapreq_table input").each(function(){
        var val = $(this).val();
        val = val ? parseFloat(val) : -1 ;
        var temp = String(val).split(".");
        if(val < 0.){
            $(this).css("background","salmon");
            $(this).val("");
            ret = false;
        } else if (temp.length==2 && temp[1].length>2){
            $(this).css("background","salmon");
            ret = false;
        } else {
            $(this).css("background","palegreen");
        }
    });
    calcTotWCR();
    return ret;
}
checkInputWCR();
