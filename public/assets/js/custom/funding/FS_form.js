function checkSelFS(){
    $("#funding_sources_table :checkbox").each(function(){
        var id_source = parseInt($(this).attr('id'))
        if(this.checked){
            $("#share_"+id_source).removeAttr("disabled");
            $("#share_"+id_source).addClass("enabledInput");
            //$(".entities_"+id_source).removeAttr("hidden");
        } else {
            //console.log($("#share_"+id_source));
            $("#share_"+id_source).attr("disabled","disabled");
            $("#share_"+id_source).css("background","");
            $("#share_"+id_source).removeClass("enabledInput");
            //$(".entities_"+id_source).attr("hidden","hidden");
        }
    });
    checkInputFS();
}

function checkInputFS(){
    var sum = 0;
    var ret = true;
    $("#funding_sources_table :input[type='number']").each(function(){
        if(!this.disabled){
            var val = $(this).val();
            val = val ? parseFloat(val) : -1 ;
            var temp = String(val).split(".");
            sum += val;
            if(val < 0.){
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
    return checkTotFS() && ret;
}

function checkTotFS(){
    var sum = 0;
    $("#funding_sources_table .enabledInput").each(function(){
        var val = $(this).val();
        val = val ? parseFloat(val) : -1 ;
        //console.log(val);
        if(val != -1){
            sum += val;
        } else {
            $("#funding_sources_table .enabledInput").css("background","salmon");
            return false;
        }
    });
    if(sum==100){
        $("#funding_sources_table .enabledInput").css("background","palegreen");
        return true;
    } else {
        //console.log("ddd");
        $("#funding_sources_table .enabledInput").css("background","salmon");
        return false;
    }
}
checkSelFS();
//checkInputFS();
