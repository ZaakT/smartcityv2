
function checkInputBenef(){
    var sum = 0;
    var ret = true;
    $("#benef_table :input[type='number']").each(function(){
        if(!this.disabled){
            var val = $(this).val();
            val = val ? parseFloat(val) : -1 ;
            var temp = String(val).split(".");
            sum += val;
            if(val <= 0.){
                $(this).css("background","salmon");
                $(this).val("");
                ret = false;
            } else if (temp.length==2 && temp[1].length>1 || val > 100){
                $(this).css("background","salmon");
                ret = false;
            } else {
                $(this).css("background","palegreen");
            }
        }
    });
    console.log(ret);
    return ret;
}

function checkTotBenef(){
    var sum = 0;
    $("#benef_table input[type='number']").each(function(){
        var val = $(this).val();
        val = val ? parseFloat(val) : -1 ;
        //console.log(val);
        if(val != -1){
            sum += val;
        } else {
            $("#benef_table input[type='number']").css("background","salmon");
            return false;
        }
    });
    calcOuputBenef();
    if(sum==100){
        $("#benef_table input[type='number']").css("background","palegreen");
        return checkInputBenef();
    } else {
        //console.log("ddd");
        $("#benef_table input[type='number']").css("background","salmon");
        return false;
    }
}

function calcOuputBenef(){
    var funding_target = parseFloat($("#funding_target").val());
    $("#benef_table input[type='number']").each(function(){
        var id_benef = parseInt($(this).attr('id').split('_')[1]);
        var share = $(this).val()/100;
        var val = share*funding_target;
        console.log(id_benef,val);
        $("#output_"+id_benef).text("£ "+val.toLocaleString("en-EN",{minimumFractionDigits: 0, maximumFractionDigits: 2}));
    });
}
checkTotBenef();