
function calcTotWCR(){
    var invest = $('#wcr_input_invest').val() ? parseFloat($('#wcr_input_invest').val()) : 0;
    var op = $('#wcr_input_op').val() ? parseFloat($('#wcr_input_op').val()) : 0;
    //console.log(invest,op);
    $("#wcr_input_tot").text((invest+op).toLocaleString('en-EN',{style:"currency",currency:deviseName,minimumFractionDigits: 0, maximumFractionDigits: 2}));
}


function checkInputWCR(id){ //passer en paramètres!!!!!
    var ret = true;
    //console.log(id);
    var val = $("#"+id).val();
    val = val ? parseFloat(val) : -1 ;
    var temp = String(val).split(".");
    if(val < 0.){
        $("#"+id).css("background","salmon");
        $("#"+id).val("");
        ret = false;
    } else if (temp.length==2 && temp[1].length>2){
        $("#"+id).css("background","salmon");
        ret = false;
    } else {
        $("#"+id).css("background","#C3E6CB");
    }
     
    calcTotWCR();
    return ret;
}

function calculatePercentage(id){
    var val = $("#"+id).val();
    val = val ? parseFloat(val) : -1 ;
    if (id == "wcr_input_invest_percent") {
        invest_goal = $('#value_invest_goal').text().replace(",","");
        cash = val * 0.01 * invest_goal;
        $('#wcr_input_invest').val(cash.toFixed(2));
        //récupérer val invest but
        // rassigner a l'input  en pound la multiplication par la valeur invest but
    } else if (id == "wcr_input_op_percent") {
        invest_goal = $('#value_op_goal').text().replace(",","");
        cash = val * 0.01 * invest_goal;
        $('#wcr_input_op').val(cash.toFixed(2));
    } else if (id == "wcr_input_invest") {
        invest_goal = $('#value_invest_goal').text().replace(",","");
        percent = (val * 100) / invest_goal;
        $('#wcr_input_invest_percent').val(percent.toFixed(0));
        //récupérer val invest but
        // rassigner a l'input  en pourcentage la multiplication par la valeur invest but
    } else if (id == "wcr_input_op") {
        invest_goal = $('#value_op_goal').text().replace(",","");
        percent = (val * 100) / invest_goal;
        $('#wcr_input_op_percent').val(percent.toFixed(0));
    }
 
}

function setNewDeviseWCR(name){
    deviseName = name;
    checkInputWCR('wcr_input_invest_percent');
    checkInputWCR('wcr_input_op_percent');
    checkInputWCR('wcr_input_invest');
    checkInputWCR('wcr_input_op');
}

setNewDeviseWCR('GBP');