function isSup(idSup, idInf){
    // Compare the values of the 2 ID ands return true if v1>v2
    var v1 = $("#"+idSup).val();
    v1 = v1 ? parseFloat(v1) : -1;
    var v2 = $("#"+idInf).val();
    v2 = v2 ? parseFloat(v2) : -1;
    return v1>=v2;
}

function isInf(idSup, idInf){
    // Compare the values of the 2 ID ands return true if v1>v2
    var v1 = $("#"+idSup).val();
    v1 = v1 ? parseFloat(v1) : -1;
    var v2 = $("#"+idInf).val();
    v2 = v2 ? parseFloat(v2) : -1;
    return v1<=v2;
}


function checkInput(id){
    var orderDict = {
    "payback": false,
    "societal_payback": false,
    "roi" : true,  
    "societal_roi" : true,
    "npv" : true,
    "societal_npv" : true,
    "nqbr" : true,
    "risks_rating" : false
    };//true if the target has to be >= than the nogo 

    id = id.getAttribute('id');
    var idType = id.substr(0, id.lastIndexOf("_"));//payback, societal_payback, ...
    var idGoal = id.substr(id.lastIndexOf("_")+1);//nogo or target
    console.log(id, idType, idGoal, orderDict[idType]);
    var val = $("#"+id).val();
    console.log(val);
    val = val ? parseFloat(val) : -1 ;        
    var temp = String(val).split(".");
    var opGoal = "nogo";
    if(idGoal == "nogo"){ opGoal = "target" ;}

    if(val < 0. || (val>100. && ( idType=="roi" || idType=="societal_roi") )){
        console.log("it's me 0 !");
        $("#"+id).css("background","salmon");
        $("#"+id).val("");
    } else if (temp.length==2 && temp[1].length>3){
        console.log("it's me 1 !");
        $("#"+id).css("background","salmon");
    } else {
        $("#"+id).css("background","#C3E6CB");
        
    }
    if(orderDict[idType]){//!(((orderDict[idType] && idGoal=="target") || (!orderDict[idType] && idGoal!="target")) && isSup(id, idType.concat("_", opGoal)))
        if(idGoal == "target" && !isSup(id, idType +"_"+ "nogo")){
            $("#"+idType +"_"+ "nogo").val($("#"+id).val());
            checkInput("#"+idType +"_"+ "nogo");
        }else if(idGoal == "nogo" && !isInf(id, idType +"_"+ "target")){
            $("#"+idType +"_"+ "target").val($("#"+id).val());
            checkInput("#"+idType +"_"+ "target");
        }
    } else {
        if(idGoal == "target" && !isInf(id, idType +"_"+ "nogo")){
            $("#"+idType +"_"+ "nogo").val($("#"+id).val());
            checkInput("#"+idType +"_"+ "nogo");
        }else if(idGoal == "nogo" && !isSup(id, idType +"_"+ "target")){
            $("#"+idType +"_"+ "target").val($("#"+id).val());
            checkInput("#"+idType +"_"+ "target");
        }
    }  


}

$("input").each(function(){
    checkInput(this);
});
