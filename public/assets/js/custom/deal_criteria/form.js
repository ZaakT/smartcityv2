function isSup(idSup, idInf){
    // Compare the values of the 2 ID ands return true if v1>v2
    var v1 = $("#"+idSup).val();
    v1 = v1 ? parseFloat(v1) : -1;
    var v2 = $("#"+idInf).val();
    v2 = v2 ? parseFloat(v2) : -1;
    return v1>v2;
}

function isInf(idSup, idInf){
    // Compare the values of the 2 ID ands return true if v1>v2
    var v1 = $("#"+idSup).val();
    v1 = v1 ? parseFloat(v1) : -1;
    var v2 = $("#"+idInf).val();
    v2 = v2 ? parseFloat(v2) : -1;
    return v1<v2;
}


function checkInput(id){
    var orderDict = {
    "operating_margin" : true,
    "payback": false,
    "societal_payback": false,
    "roi" : true,  
    "societal_roi" : true,
    "npv" : true,
    "societal_npv" : true,
    "nqbr" : true,
    "risks_rating" : false
    };//true if the target has to be >= than the nogo 
    var projDuration = $("#projDuration").text();
    var test= true;
    id = id.getAttribute('id');
    var idType = id.substr(0, id.lastIndexOf("_"));//payback, societal_payback, ...
    var idGoal = id.substr(id.lastIndexOf("_")+1);//nogo or target
    //console.log(id, idType, idGoal, orderDict[idType]);
    var val = $("#"+id).val();
    val = val ? parseFloat(val) : -1 ;        
    var temp = String(val).split(".");
    if(idGoal != "check" && $("#"+idType+"_check").is(':checked')){
        var opGoal = "nogo";
        if(idGoal == "nogo"){ opGoal = "target" ;}
        //console.log(val, projDuration)
        if(val < 0. || (val>100. && ( idType=="roi" || idType=="societal_roi")) || (val>10. && (idType=="risks_rating" ||idType=="nqbr" )) || (val > projDuration && (idType=="payback"))){
            $("#"+id).css("background","salmon");
            test = false;
            //$("#"+id).val("");
        } else if (temp.length==2 && temp[1].length>3){
            test = false;
            $("#"+id).css("background","salmon");
        } else {
            $("#"+id).css("background","#C3E6CB");
            
        }
        if(orderDict[idType]){//!(((orderDict[idType] && idGoal=="target") || (!orderDict[idType] && idGoal!="target")) && isSup(id, idType.concat("_", opGoal)))
            if(idGoal == "target" && !isSup(id, idType +"_"+ "nogo")){
                //$("#"+idType +"_"+ "nogo").val($("#"+id).val());
                test = false;
                $("#"+idType +"_"+ "nogo").css("background","salmon");
                //checkInput("#"+idType +"_"+ "nogo");
            }else if(idGoal == "nogo" && !isInf(id, idType +"_"+ "target")){
                //$("#"+idType +"_"+ "target").val($("#"+id).val());
                test = false;
                $("#"+idType +"_"+ "nogo").css("background","salmon");
                //checkInput("#"+idType +"_"+ "target");
            }
        } else {
            if(idGoal == "target" && !isInf(id, idType +"_"+ "nogo")){
                //$("#"+idType +"_"+ "nogo").val($("#"+id).val());
                test = false;
                $("#"+idType +"_"+ "nogo").css("background","salmon");
                //checkInput("#"+idType +"_"+ "nogo");
            }else if(idGoal == "nogo" && !isSup(id, idType +"_"+ "target")){
                //$("#"+idType +"_"+ "target").val($("#"+id).val());
                test = false;
                $("#"+idType +"_"+ "nogo").css("background","salmon");
                //checkInput("#"+idType +"_"+ "target");
            }
        }  
    }else{
        console.log("#"+idType+"_target");
        if($("#"+id).is(':checked')){

            $("#"+idType+"_target").removeAttr("disabled");
            $("#"+idType+"_nogo").removeAttr("disabled");
            $("#"+idType+"_target").attr("required", true);
            $("#"+idType+"_nogo").attr("required", true);
        }else{
            $("#"+idType+"_target").attr("disabled", true);
            $("#"+idType+"_nogo").attr("disabled", true);
            $("#"+idType+"_target").removeAttr("required");
            $("#"+idType+"_nogo").removeAttr("required");
            $("#"+idType+"_target").css("background","#C3E6CB");
            $("#"+idType+"_nogo").css("background","#C3E6CB");
            $("#"+idType+"_target").val("");
            $("#"+idType+"_nogo").val("");
        }
    }
    return test



}

function checkSubmit(){
    test= true;
    $("input").each(function(){
        if( !checkInput(this)){
            test= false
        }
    });
    return test;
    
}

checkSubmit();


